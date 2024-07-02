<?php

namespace Database\Factories;

use App\Models\Commande;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commande>
 */
class CommandeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Commande::class;

    public function definition(): array
    {
        return [
            //
            'titre' => $this->faker->sentence,
            'date' => $this->faker->date,
            'montant' => $this->faker->randomFloat(2, 50, 500),
            'statut' => $this->faker->randomElement(['attente', 'paye', 'livre']),
            //'reference' => $this->faker->uuid,
            'latitude' => $this->faker->optional()->latitude,
            'longitude' => $this->faker->optional()->longitude,
            'user_id' => User::factory()
        ];
    }
}
