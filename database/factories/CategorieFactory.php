<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

use function PHPUnit\Framework\isNull;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categorie>
 */
class CategorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Categorie::class;
    public function definition(): array
    {
        return [
            //
            'nom' => $this->faker->word,
            'description' => $this->faker->sentence,
            'superCategorie_id' => function () {
                // $cat=Categorie::all();
                // if (isNull($cat)) {
                //     return null;
                // }
                // else
                //  return Categorie::factory()->create()->id;
                $categorie = Categorie::inRandomOrder()->first();
                return optional($categorie)->id;
            }
        ];
    }
}
