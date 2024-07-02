<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Article::class;
    public function definition(): array
    {
        return [
            //
            'nom' => $this->faker->word,
            'description' => $this->faker->sentence,
            'mini_description' => $this->faker->sentence,
            'ancienPrix' => $this->faker->randomFloat(2, 10, 100),
            'prix' => $this->faker->randomFloat(2, 10, 100),
            'quantite' => $this->faker->numberBetween(1, 100),
           // 'categorieArticle_id' => Categorie::factory()
        ];
    }
}
