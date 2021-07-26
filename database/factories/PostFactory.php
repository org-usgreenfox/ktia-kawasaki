<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'store_name' => $this->faker->word,
            'address' => $this->faker->address,
            'store_url' => $this->faker->url,
            'sns_url' => $this->faker->url,
            'comment' => $this->faker->realText
            
        ];
    }
}
