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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



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
        if (empty($a)) {
            return;
        }
    
        DB::transaction(function () use ($a, $b) {
            $user = User::find($a);
    
            if (!$user) {
                $this->js("
                    Swal.fire({
                        title: 'Erreur!',
                        text: 'Utilisateur introuvable.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                ");
                return;
            }
    
            // Verrouille la ligne pour éviter une double réservation
            $heureajoute = RendezvousHoraire::where('id', $b)->lockForUpdate()->first();
    
            if (!$heureajoute) {
                $this->js("
                    Swal.fire({
                        title: 'Erreur!',
                        text: 'Ce créneau n'existe pas.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                ");
                return;
            }
    
            if ($heureajoute->userid == 0) {
                // Mise à jour de la réservation
                $heureajoute->userid = $user->id;
                $heureajoute->usernom = $user->name;
                $heureajoute->usermail = $user->email;
                $heureajoute->save();
    
                $this->js("
                    Swal.fire({
                        title: 'Bravo!',
                        text: 'Le rendez-vous a été ajouté avec succès.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                ");
    
                $this->initier1();
                $this->initier2();
            } else {
                // Le créneau est déjà réservé
                $this->js("
                    Swal.fire({
                        title: 'Attention!',
                        text: 'Ce créneau est déjà pris.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                ");
            }
        });
    } 

    
    public function ajouter2($a, $b)
{
    DB::beginTransaction();

    try {
        $user = User::where('email', $a)->first();

        if (!$user) {
            return $this->js("
                Swal.fire({
                    title: 'Attention!',
                    text: 'Cette adresse mail n'existe pas!',
                    icon: 'error',
                    confirmButtonText: 'Valider'
                })
            ");
        }

        $heureajoute = RendezvousHoraire::where('id', $b)->lockForUpdate()->first();

        if ($heureajoute) {
            if ($heureajoute->userid == 0) {
                $heureajoute->userid = $user->id;
                $heureajoute->usernom = $user->name;
                $heureajoute->usermail = $user->email;
                $heureajoute->save();

                DB::commit();

                $this->js("
                    Swal.fire({
                        title: 'Bravo!',
                        text: 'Le rendez-vous a été ajouté',
                        icon: 'success',
                        confirmButtonText: 'Valider'
                    })
                ");

                $this->initier1();
                $this->initier2();
            } elseif ($heureajoute->userid != 0) {
                DB::rollBack();

                $this->js("
                    Swal.fire({
                        title: 'Attention!',
                        text: 'Il y a déjà un rendez-vous!',
                        icon: 'error',
                        confirmButtonText: 'Valider'
                    })
                ");

                $this->initier1();
                $this->initier2();
            }
        } else {
            DB::rollBack();

            $this->js("
                Swal.fire({
                    title: 'Erreur!',
                    text: 'Heure de rendez-vous non trouvée!',
                    icon: 'error',
                    confirmButtonText: 'Valider'
                })
            ");
        }
    } catch (\Exception $e) {
        DB::rollBack();

        $this->js("
            Swal.fire({
                title: 'Erreur!',
                text: 'Une erreur est survenue, veuillez réessayer.',
                icon: 'error',
                confirmButtonText: 'Valider'
            })
        ");
    }
}



public function modifier1($a, $b) {
    if (empty($a) || empty($b)) {
        return; // Prevent unnecessary queries if inputs are empty
    }

    DB::beginTransaction();
    
    try {
        // Lock the user record to prevent race conditions
        $user = User::find($a);

        if (!$user) {
            DB::rollBack();
            return; // Exit if user is not found
        }

        // Lock the rendezvousHoraire record for update
        $heureajoute = RendezvousHoraire::where('id', $b)->lockForUpdate()->first();

        if (!$heureajoute) {
            DB::rollBack();
            return; // Exit if the record is not found
        }

        // Update the rendezvousHoraire record
        $heureajoute->userid = $user->id;
        $heureajoute->usernom = $user->name;
        $heureajoute->usermail = $user->email;
        $heureajoute->save();

        DB::commit(); // Commit the transaction only if everything succeeds

        // Show success message using SweetAlert
        $this->js("
            Swal.fire({
                title: 'Bravo!',
                text: 'Le rendez-vous a été ajouté avec succès',
                icon: 'success',
                confirmButtonText: 'Valider'
            })
        ");

        // Call the necessary initialization methods
        $this->initier1();
        $this->initier2();

    } catch (\Exception $e) {
        DB::rollBack(); // Rollback the transaction if any error occurs
        report($e); // Log the error for debugging
    }
}


public function modifier2($a, $b)
{
    DB::transaction(function () use ($a, $b) {
        $user = User::where('email', $a)->lockForUpdate()->first();

        if (!$user) {
            return $this->js("
                Swal.fire({
                  title: 'Attention!',
                  text: 'Cette adresse mail n\'existe pas!',
                  icon: 'error',
                  confirmButtonText: 'Valider'
                })
            ");
        }

        $heureajoute = RendezvousHoraire::lockForUpdate()->find($b);

        if ($heureajoute) {
            $heureajoute->userid = $user->id;
            $heureajoute->usernom = $user->name;
            $heureajoute->usermail = $user->email;
            $heureajoute->save();

            $this->js("
                Swal.fire({
                  title: 'Bravo!',
                  text: 'Le rendez-vous a été ajouté avec succès',
                  icon: 'success',
                  confirmButtonText: 'Valider'
                })
            ");

            $this->initier1();
            $this->initier2();
        }
    });
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