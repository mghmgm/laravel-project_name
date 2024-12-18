<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(
            // ArticleSeeder::class,
            UserSeeder::class,
        );
        // Article::factory(10)->has(Comment::factory(3))->create();
    }
}
