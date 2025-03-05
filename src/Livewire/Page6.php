<?php

namespace Rendezvous\Rendezvous\Livewire;
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
use Livewire\Component;
use App\Models\User ;
use Auth ;
use Carbon\Carbon ;
use Rendezvous\Rendezvous\Models\RendezvousHoraire ;
use Rendezvous\Rendezvous\Models\RendezvousJouractif ;

class Page6 extends Component
{
    public $lesheures ;

    public function mount() {
        $date = Carbon::now('Europe/Paris')->startOfDay();
                           $this->lesheures =  RendezvousHoraire::where('ladate','>=',$date)
                           ->where('userid',Auth::user()->id)
                            ->get();
        
        
    }

    public function render()
    {
        return view('rendezvous::livewire.page6')
         ->layout('rendezvous::layouts.app2');
    }
}