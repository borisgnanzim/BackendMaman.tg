<?php

namespace Database\Seeders;

use App\Models\CategorieArticle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CategorieArticle::factory()->count(10)->create();
    }
}
