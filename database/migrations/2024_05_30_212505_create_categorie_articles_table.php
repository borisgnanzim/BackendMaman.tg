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
        Schema::create('categorie_articles', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            //$table->unsignedBigInteger('categorie_id');
            //$table->unsignedBigInteger('article_id');
            $table->foreignId('categorie_id')->constrained('categories');
            $table->foreignId('article_id')->constrained('articles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catégorie_articles');
    }
};
