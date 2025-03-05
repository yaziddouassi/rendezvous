<?php

namespace Rendezvous\Rendezvous\Livewire;
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\WithPagination;
use Rendezvous\Rendezvous\Utils\Rdvous;

use App\Models\User;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon ;
use Rendezvous\Rendezvous\Models\RendezvousHoraire ;
use Rendezvous\Rendezvous\Models\RendezvousJouractif ;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Collection;


class Page3 extends Component
{  
  
    use WithPagination;

  
    #[Url] 
    public $search = '';
   
    public $jour ;
    public $mois ;
    public $annee ;
    public $journee ;
    public $madate ;
    public $ladate;
    public $lesheures ;

    public function Mount($madate)
    {
        $rdvous = new Rdvous() ;

        $rdvous->initier($madate);

        $this->jour = $rdvous->getJour() ;
        $this->mois = $rdvous->getMois();
        $this->annee = $rdvous->getAnnee() ;
        $this->journee = $rdvous->getJournee() ;
        $this->madate = $madate;
 
        $this->initier1();
    } 

   
    public function initier1() {

        $this->lesheures = RendezvousHoraire::where('annee',$this->annee)
        ->where('mois',$this->mois)
         ->where('jour',$this->jour)
        ->orderBy('debut')
        ->get() ;

     }


     public function initier2() {

        $count1 =  RendezvousHoraire::where('annee',$this->annee)
        ->where('mois',$this->mois)
        ->where('jour',$this->jour)
        ->where('userid',0)
        ->count() ;

        $count2 =  RendezvousHoraire::where('annee',$this->annee)
        ->where('mois',$this->mois)
        ->where('jour',$this->jour)
        ->where('userid','!=',0)
        ->count() ;

       $jouractif = RendezvousJouractif::where('annee',$this->annee)
              ->where('mois',$this->mois)
               ->where('jour',$this->jour)
               ->first() ;

        if(!$jouractif) {


            RendezvousJouractif::create([
                'annee' => $this->annee ,
                  'mois' => $this->mois ,
                  'jour' => $this->jour ,
                  'journee' =>  $this->journee,
                  'ladate' => $this->ladate ,
                  'nbheuredispo' => $count1 ,
                 'nbheureserve' => $count2
            ]) ;  

            }

           else {

            RendezvousJouractif::find($jouractif->id)->update([
                 'nbheuredispo' => $count1 ,
               'nbheureserve' => $count2
                  ]);

             }


    }

   

    public function supprimer1($leid) {

       $horaire = RendezvousHoraire::find($leid) ;

        if($horaire) {

             if($horaire->userid == 0) {

                RendezvousHoraire::where('id',$leid)->delete() ;

                $this->js("
                Swal.fire({
                  title: 'Bravo!',
                  text: 'l heure a été supprimée',
                  icon: 'success',
                  confirmButtonText: 'valider'
                                })
                            ");

                $this->initier2();
               $this->initier1() ;

 
             }

             elseif($horaire->userid != 0) {

               $this->js("
                Swal.fire({
                  title: 'il y a déja un rendez-vous!',
                  text: 'les heures ont été ajoutées',
                  icon: 'error',
                  confirmButtonText: 'valider'
                                })
                            ");
             
              $this->initier2();
             $this->initier1() ;

              }

        }

   

     

    }



    public function supprimer2($leid) {


      RendezvousHoraire::where('id',$leid)->delete() ;

      $this->js("
                Swal.fire({
                  title: 'Bravo!',
                  text: 'les heures ont été ajoutées',
                  icon: 'success',
                  confirmButtonText: 'valider'
                                })
                            ");
   
      $this->initier2();
     $this->initier1() ;


    }
  



    public function searchrezet() {
          $this->search = '';
    }


   
    public function render()
    {
 
        if($this->search == '') {
            $users = User::paginate(1);
           }
   
           if($this->search != '') {
             
               $users = User::where('name', 'LIKE', '%'.$this->search.'%')
                       ->orWhere('email', 'LIKE', '%'.$this->search.'%')
                       ->paginate(1);
              }
   

        return view('rendezvous::livewire.page3',[
            'users' => $users,
        ])
         ->layout('rendezvous::layouts.app');
    }
}