<?php

namespace Rendezvous\Rendezvous\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezvousHoraire extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'debut',
        'jour',
        'mois',
        'annee',
        'journee',
        'ladate',
        'userid',
        'usernom',
        'usermail',
    ];
}
