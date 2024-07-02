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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->text('mini_description')->nullable();
            $table->float('ancienPrix');
            $table->float('prix');
            $table->unsignedInteger('quantite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categorie_articles', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
        });

        Schema::dropIfExists('articles');
    }
};
