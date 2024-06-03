<?php

namespace Database\Factories;

use App\Models\Commande;
use App\Models\Livraison;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livraison>
 */
class LivraisonFactory extends Factory
{
    protected $model = Livraison::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'titre' => $this->faker->sentence,
            'date' => $this->faker->date,
            'nomClient' => $this->faker->name,
            'adresse' => $this->faker->address,
            'commande_id' => Commande::factory()
        ];
    }
}
