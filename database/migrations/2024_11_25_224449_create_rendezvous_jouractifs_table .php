<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rendezvous_jouractifs', function (Blueprint $table) {
            $table->id();

            $table->string('jour');
            $table->string('mois');
            $table->string('annee');
            $table->string('nbheuredispo');
            $table->string('nbheureserve');
            $table->string('journee');
            $table->date('ladate');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jouractifs');
    }
};
