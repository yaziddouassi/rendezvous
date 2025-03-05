<?php

namespace Rendezvous\Rendezvous\Livewire;
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');


use Livewire\Component;
use Rendezvous\Rendezvous\Models\RendezvousHoraire ;
use Rendezvous\Rendezvous\Models\RendezvousJouractif ;
use App\Models\User ;
use Carbon\Carbon ;
use Auth ;

class Petitrdv extends Component
{

    public $ladate ;
    public $journee ;
    public $lesheures ;
    public $annee ;
    public $mois ;
    public $jour ;


    
    public function mount() {
        $this->charger() ;
    }


    public function valider($a)
    {
      

        
        $date = Carbon::yesterday();

        $yesterday = Carbon::create( $date->year,$date->month,$date->day,23,59,59,'Europe/Paris') ;

        $count = RendezvousHoraire::where('userid',Auth::user()->id)
                          ->where('ladate','>',$yesterday)
                         ->count() ;
   
                         
            if($count != 0) {

                $this->js("
                Swal.fire({
                  title: 'Attention!',
                  text: 'Vous déja un rendez-vous',
                  icon: 'error',
                  confirmButtonText: 'valider'
                                })
                            ");          
                $this->charger() ;
                            }
                
            if($count == 0) {
                    
                            
                            $horaire = RendezvousHoraire::where('id',$a)
                                                ->where('userid','=',0)
                                                ->first() ;
                
                            if($horaire) {
                
                                $horaire->userid = Auth::user()->id ;
                                $horaire->usernom = Auth::user()->name ;
                                $horaire->usermail = Auth::user()->email ;
                                $horaire->save();
                
                                $this->js("
                                  Swal.fire({
                                    title: 'Bravo!',
                                    text: 'le rendez-vous a été pris',
                                    icon: 'success',
                                    confirmButtonText: 'valider'
                                })
                            ");
                                
                                $this->initier() ;
                                $this->charger() ;
                            }
                
                            elseif(!$horaire) {
                
                                $this->js("
                                Swal.fire({
                                  title: 'Attention!',
                                  text: 'le rendez-vous n est plus disponible !',
                                  icon: 'error',
                                  confirmButtonText: 'valider'
                                                })
                                            ");

                                $this->charger() ;
                            }
                
                         }
                



    }










    public function initier() {

        $count1 =  RendezvousHoraire::where('ladate',$this->ladate)
                          ->where('userid',0)
                          ->count() ;

        $count2 =  RendezvousHoraire::where('ladate',$this->ladate)
                          ->where('userid','!=',0)
                          ->count() ;

        $jouractif = RendezvousJouractif::where('ladate',$this->ladate)
                  ->first() ;


        if($jouractif) {

            RendezvousJouractif::find($jouractif->id)->update([
                        'nbheuredispo' => $count1 ,
                         'nbheureserve' => $count2
                        ]);
        
               }
      

    }



    public function charger()
    {
        $this->lesheures = RendezvousHoraire::where('ladate',$this->ladate)
                                    ->where('userid',0)
                                    ->orderBy('debut')
                                  ->get();
    }



    public function render()
    {
        return view('rendezvous::livewire.petitrdv');
    }
}
