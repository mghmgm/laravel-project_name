<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'=>$this->faker->sentence(),
            'date'=>$this->faker->date(),
            'desc'=>$this->faker->paragraph(),
            'user_id'=>User::factory(),
        ];
    }
}
