<?php

namespace Database\Factories;

use App\Models\Commande;
use App\Models\Payement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payement>
 */
class PayementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Payement::class;

    public function definition(): array
    {
        return [
            //
            'titre' => $this->faker->sentence,
            'solde' => $this->faker->randomFloat(2, 50, 500),
            'mode_de_paiment' => $this->faker->word,
            'date' => $this->faker->date,
            'user_id' => User::factory(),
            'commande_id' => Commande::factory()
        ];
    }
}
