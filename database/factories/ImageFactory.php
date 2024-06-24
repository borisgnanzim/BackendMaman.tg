<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            //
            'titre' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'path' => $this->faker->imageUrl,
            //'url' => $this->faker->imageUrl,
            'article_id' => Article::factory()
        ];
    }
}
