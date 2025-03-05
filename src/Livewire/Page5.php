<?php

namespace Rendezvous\Rendezvous\Livewire;
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
use Livewire\Component;
use App\Models\User ;
use Carbon\Carbon ;
use Auth ;

class Page5 extends Component
{

    public function mount() {

      
    }

    public function render()
    {
        return view('rendezvous::livewire.page5')
         ->layout('rendezvous::layouts.app2');
    }
}
