<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     //
    //     Categorie::factory(10)->create();
    // }

    public function run(): void
    {
        // Define categories and subcategories
        $categories = [
            'Futur Maman' => ['Robes', 'chemises', 'Pulls', 'Pantalons', 'Accessoires', 'Détergents'],
            'Bébé' => ['Survêtements', 'Sous vêtements', 'Ensembles', 'Pulls', 'Accessoires', 'chaussures'],
            'Allaitement' => ['Biberons', 'Tire-Lait', 'lait', 'Accessoire'],
            'Espaces Jouets' => ['Jouets bébé', 'jeux de créativité', 'Autres']
        ];

        foreach ($categories as $parentName => $subCategories) {
            // Create parent category
            $parent = Categorie::factory()->create([
                'nom' => $parentName,
                //'description' => $this->faker->sentence,
            ]);

            // Create subcategories
            foreach ($subCategories as $subCategoryName) {
                Categorie::factory()->withParent($parent)->create([
                    'nom' => $subCategoryName,
                    //'description' => $this->faker->sentence,
                ]);
            }
        }
    }
}
