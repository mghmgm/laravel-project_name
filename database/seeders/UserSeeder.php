<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            "name"=>"moderator",
            "email"=>"moderator@mail.ru",
            "password"=>Hash::make('123456'),
            "role"=>"moderator"
        ]);
    }
}
