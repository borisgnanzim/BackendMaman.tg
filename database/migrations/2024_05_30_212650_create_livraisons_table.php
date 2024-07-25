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
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
           // $table->dateTime('date')->nullable();
            $table->string('nomClient')->nullable();
            $table->string('ville')->nullable();
            $table->string('adresse');
            $table->string('reference')->unique();
            $table->enum('destinataire', ['moi', 'autre'])->default('moi');
            //$table->string('reference');
            //$table->unsignedBigInteger('commande_id');
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livraisons');
    }
};
