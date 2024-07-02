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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->dateTime('date');
            $table->float('montant');
            $table->enum('statut', ['attente', 'paye', 'livre'])->default('attente');
            $table->string('reference')->unique();
            $table->decimal('latitude', 10, 7)->nullable(); // geoloc
            $table->decimal('longitude', 10, 7)->nullable(); // geoloc
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
