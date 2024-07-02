<?php

namespace Database\Factories;

use App\Models\Commande;
use App\Models\Livraison;
use Illuminate\Database\Eloquent\Factories\Factory;
//
use Illuminate\Support\Str;

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
            'ville' => $this->faker->optional($weight = 0.5)->city,
            'adresse' => $this->faker->address,
            //'reference' => Str::random(10),
            'destinataire' =>'moi',
            //'reference' => $this->faker->unique()->regexify('[A-Z0-9]{8}'), // Génère une chaîne unique de 8 caractères alphanumériques
            'commande_id' => Commande::factory(),
        ];
    }
}
