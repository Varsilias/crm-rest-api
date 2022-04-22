<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "category_id" => rand(1, 10),
            "title" => $this->faker->sentence(),
            "body" => $this->faker->paragraph(),
            "author" => $this->faker->name()
        ];
    }
}
