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

class Myrdv extends Component
{

      
    public $lesjours ;
    public $lesheures ;
    public $today ;
    public $count ;


    public function mount() {

       

        $carbon = Carbon::yesterday() ;

        $now=  Carbon::createFromDate($carbon->year,$carbon->month ,$carbon->day, 'Europe/Paris' );

        $this->today = $now ;


        $this->count = 6 ;

        $this->initier() ;

        

    }


    
    public function initier() {

        $this->lesjours = RendezvousJouractif:: where('ladate','>',$this->today)
              ->where('nbheuredispo','>',0)
              ->orderBy('ladate')
               ->limit($this->count)
             ->get() ;


        $counter = count($this->lesjours) ;

        if($counter == 0 ) {

            

        }


            }



        public function ajouter() {

            $this->count =  $this->count + 5 ;

             $this->initier() ;
        }
         


    public function render()
    {
        return view('rendezvous::livewire.myrdv');
    }
}
