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

class Page1 extends Component
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
       
        $this->ladate=  Carbon::create($this->annee,$this->mois ,$this->jour,23,59,59, 'Europe/Paris' );

        $this->initier();
    } 


    public function searchrezet() {
        $this->search = '';
  }


  
  public function initier() {

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
            'journee' => $this->journee ,
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



 #[On('rafraichir2')] 
 public function rafraichir2() {
  
    $this->initier();
}


public function valider($heureprises)  {

       


    foreach($heureprises as $key=>$heureprise) {

         
      $heure =  RendezvousHoraire::where('annee',$this->annee)
        ->where('mois',$this->mois)
         ->where('jour',$this->jour)
         ->where('debut',$heureprise)
        ->first() ;


        if(!$heure) {

          

            RendezvousHoraire::create([
                    'annee' => $this->annee ,
                    'mois' => $this->mois ,
                    'jour' => $this->jour ,
                    'debut' => $heureprise ,
                    'journee' => $this->journee,
                    'ladate' => $this->ladate ,
                    'userid' => 0 ,
                    'usernom' => null ,
                    'usermail' => null,
            ]);
        }




    }

    
    $this->initier2();
    $this->initier() ;

    $this->js("
            Swal.fire({
              title: 'Bravo!',
              text: 'les heures ont été ajoutées',
              icon: 'success',
              confirmButtonText: 'valider'
                            })
                        ");

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


        return view('rendezvous::livewire.page1',[
            'users' => $users,
        ])
         ->layout('rendezvous::layouts.app');
    }
}