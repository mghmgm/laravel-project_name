<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'=>$this->faker->word(),
            'desc'=>$this->faker->paragraph(),
            'user_id'=>random_int(1,10),
        ];
    }
}
