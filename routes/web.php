<?php

use Illuminate\Support\Facades\Route;



Route::middleware('web')->group(function () {
   
    Route::get('/kader', function () {
        return view('welcome');
    });
 
    Route::get('/admin/rdv/{madate}/horaire',\Rendezvous\Rendezvous\Livewire\Page1::class);
    Route::get('/admin/rdv/{madate}/ajouter',\Rendezvous\Rendezvous\Livewire\Page2::class);
    Route::get('/admin/rdv/{madate}/supprimer',\Rendezvous\Rendezvous\Livewire\Page3::class);
    Route::get('/admin/rdv/{madate}/mois',\Rendezvous\Rendezvous\Livewire\Page4::class);
    Route::get('/rendez-vous',\Rendezvous\Rendezvous\Livewire\Page5::class)->middleware('auth');
    Route::get('/rendez-vous-account',\Rendezvous\Rendezvous\Livewire\Page6::class)->middleware('auth');
});
