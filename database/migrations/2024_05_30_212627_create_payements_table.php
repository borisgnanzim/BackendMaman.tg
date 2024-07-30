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
        Schema::create('payements', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->dateTime('date');
            $table->string('modePayement');
            $table->unsignedInteger('solde');
            $table->string('reference')->unique();
            //$table->unsignedBigInteger('commande_id');
            //$table->unsignedBigInteger('user_id');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payements');
    }
};
