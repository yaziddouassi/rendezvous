<?php

namespace Rendezvous\Rendezvous;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;

class RendezvousServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../resources/views','rendezvous');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        
        Livewire::component('rendezvous.page1', \Rendezvous\Rendezvous\Livewire\Page1::class);
        Livewire::component('rendezvous.page2', \Rendezvous\Rendezvous\Livewire\Page2::class);
        Livewire::component('rendezvous.page3', \Rendezvous\Rendezvous\Livewire\Page3::class);
        Livewire::component('rendezvous.page4', \Rendezvous\Rendezvous\Livewire\Page4::class);
        Livewire::component('rendezvous.page5', \Rendezvous\Rendezvous\Livewire\Page5::class);
        Livewire::component('rendezvous.page6', \Rendezvous\Rendezvous\Livewire\Page6::class);
        Livewire::component('rendezvous.myrdv', \Rendezvous\Rendezvous\Livewire\Myrdv::class);
        Livewire::component('rendezvous.petitrdv', \Rendezvous\Rendezvous\Livewire\Petitrdv::class);
        Livewire::component('rendezvous.sidebarre', \Rendezvous\Rendezvous\Livewire\Sidebarre::class);
    }
}