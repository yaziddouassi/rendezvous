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




class Page2 extends Component
{  
  
    use WithPagination;

    #[Url] 
    public $search = '';
   
    public $jour ;
    public $mois ;
    public $annee ;
    public $journee ;
    public $madate ;

    public $lesheures ;
    public $ladate ;
    public $open5 ;
    public $open6;
    public $ident ;
    public $hour ;
    public $inputuser ;

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
        $this->initier1();
    } 

    public function valideruser($a) {
        $user = User::where('email',$a)->first();
        if(!$user) {
           return dd('ssz');
        }
    }


    public function ouvrir1($a , $b) {
        $this->inputuser = '';
        $this->hour = $a ;
        $this->ident = $b ;
        $this->open5 = true ;
        $this->open6 = false ;
       }
  
       public function ouvrir2($a , $b) {
        $this->inputuser = '';
        $this->hour = $a ;
        $this->ident = $b ;
        $this->open5 = false ;
        $this->open6 = true ;
       }
  
       public function initier1() {
  
        $this->open5 = false ;
        $this->open6 = false ;
        $this->hour = '' ;
        $this->ident = '' ;
        $this->inputuser = '';
  
  
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


      public function ajouter1($a, $b) {
  
  
        if($a != '') {
           
           $user = User::find($a) ;

           $heureajoute = RendezvousHoraire::find($b);

           if($user) {

                  if($heureajoute) {

                        if($heureajoute->userid == 0) {

                           $heureajoute->userid = $user->id ;
                           $heureajoute->usernom = $user->name ;
                           $heureajoute->usermail = $user->email ;
                           $heureajoute->save();
                         
                           $this->js("
                               Swal.fire({
                                 title: 'Bravo!',
                                 text: 'le rendez-vous a été ajoutée',
                                 icon: 'success',
                                confirmButtonText: 'valider'
                               })
                           ");
                         
                           $this->initier1();
                           $this->initier2();
                        }


                        elseif($heureajoute->userid != 0) {

                          $this->js("
                               Swal.fire({
                                 title: 'Attention!',
                                 text: 'il y a deja un rendez-vous!',
                                 icon: 'errror',
                                confirmButtonText: 'valider'
                               })
                           ");

                           $this->initier1();
                           $this->initier2();

                        }

                  }
           }


            

        }

    }


    public function ajouter2($a,$b) {

         $user = User::where('email',$a)->first();
         if(!$user) {
           return
           $this->js("
                               Swal.fire({
                                 title: 'Attention!',
                                 text: 'cette adresse mail nexiste pas!',
                                 icon: 'errror',
                                confirmButtonText: 'valider'
                               })
                           ");

         }

         $heureajoute = RendezvousHoraire::find($b);

         if($heureajoute) {

           if($heureajoute->userid == 0) {

              $heureajoute->userid = $user->id ;
              $heureajoute->usernom = $user->name ;
              $heureajoute->usermail = $user->email ;
              $heureajoute->save();
            
              $this->js("
                  Swal.fire({
                    title: 'Bravo!',
                    text: 'le rendez-vous a été ajoutée',
                    icon: 'success',
                   confirmButtonText: 'valider'
                  })
              ");
            
              $this->initier1();
              $this->initier2();
           }


           elseif($heureajoute->userid != 0) {

             $this->js("
                  Swal.fire({
                    title: 'Attention!',
                    text: 'il y a deja un rendez-vous!',
                    icon: 'errror',
                   confirmButtonText: 'valider'
                  })
              ");

              $this->initier1();
              $this->initier2();

           }

     }

    }



    public function modifier1($a, $b) {


      if($a != '') {

        $user = User::find($a) ;

        $heureajoute = RendezvousHoraire::find($b);

        
        if($user) {

             if($heureajoute) {

              $heureajoute->userid = $user->id ;
              $heureajoute->usernom = $user->name ;
              $heureajoute->usermail = $user->email ;
              $heureajoute->save();
            
              $this->js("
                               Swal.fire({
                                 title: 'Bravo!',
                                 text: 'le rendez-vous a été ajoutée2',
                                 icon: 'success',
                                confirmButtonText: 'valider'
                               })
                           ");
            
              $this->initier1();
              $this->initier2();
             }
        }


       
       }

  }


  public function modifier2($a, $b) {

    $user = User::where('email',$a)->first();
     if(!$user) {
        return
        $this->js("
        Swal.fire({
          title: 'Attention!',
          text: 'cette adresse mail nexiste pas!',
          icon: 'errror',
         confirmButtonText: 'valider'
        })
    ");
     }

     $heureajoute = RendezvousHoraire::find($b);

     if($heureajoute) {

       $heureajoute->userid = $user->id ;
       $heureajoute->usernom = $user->name ;
       $heureajoute->usermail = $user->email ;
       $heureajoute->save();
     
       $this->js("
                        Swal.fire({
                          title: 'Bravo!',
                          text: 'le rendez-vous a été ajoutée2',
                          icon: 'success',
                         confirmButtonText: 'valider'
                        })
                    ");
     
       $this->initier1();
       $this->initier2();
      }


  }



  public function supprimer($a) {

     $heureajoute = RendezvousHoraire::find($a);

     if($heureajoute) {

        $heureajoute->userid = 0 ;
        $heureajoute->usernom = null ;
        $heureajoute->usermail = null ;
        $heureajoute->save();



     }


     $this->js("
               Swal.fire({
                 title: 'Bravo!',
                 text: 'le rendez-vous a été supprimée',
                 icon: 'success',
                 confirmButtonText: 'valider'
                               })
                           ");

    
      $this->initier1();
      $this->initier2();


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
   


        return view('rendezvous::livewire.page2',[
            'users' => $users,
        ])
         ->layout('rendezvous::layouts.app');
    }
}