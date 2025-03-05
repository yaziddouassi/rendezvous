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

class Page4 extends Component
{  
  
    use WithPagination;

    #[Url] 
    public $search = '';
   
    public $jour ;
    public $mois ;
    public $annee ;
    public $journee ;
    public $madate ;

    public $lesjours ;
    public $reserves ;


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

        $this->lesjours = RendezvousJouractif::where('annee',$this->annee)
                                   ->where('mois',$this->mois)
                                   ->where('nbheureserve','>' ,0)
                                   ->orderBy('jour')
                                   ->get() ; 
        $this->reserves = RendezvousHoraire::where('annee',$this->annee)
                                 ->where('mois',$this->mois)
                                  ->where('userid','!=',0)
                                  ->orderBy('debut')
                                  ->get() ;
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



        return view('rendezvous::livewire.page4',[
            'users' => $users,
        ])
         ->layout('rendezvous::layouts.app');
    }
}