<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Commande;
use App\Models\LigneCommande;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LigneCommande>
 */
class LigneCommandeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = LigneCommande::class;

    public function definition(): array
    {
        return [
            //
            'titre' => $this->faker->sentence,
            'quantite' => $this->faker->numberBetween(1, 10),
            'prix' => $this->faker->randomFloat(2, 10, 100),
            'commande_id' => Commande::factory(),
            'article_id' => Article::factory()
        ];
    }
}
