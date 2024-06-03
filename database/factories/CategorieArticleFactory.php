<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\CategorieArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategorieArticle>
 */
class CategorieArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = CategorieArticle::class;

    public function definition(): array
    {
        return [
            //
            'titre' => $this->faker->sentence,
            'categorie_id' => Categorie::factory(),
            'article_id' => Article::factory(),
        ];
    }
}
