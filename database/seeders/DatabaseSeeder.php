<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Categorie;
use App\Models\Livraison;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Categorie::factory()->create([
        //         'nom' => 'Garçon',
        //         'description' => 'Vetement',
        //     ]);


        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
            CategorieSeeder::class,
            ArticleSeeder::class,
            CategorieArticleSeeder::class,
            ImageSeeder::class,
            LigneCommandeSeeder::class,
            CommandeSeeder::class,
            PayementSeeder::class,
            LivraisonSeeder::class,
        ]);
    }
}
