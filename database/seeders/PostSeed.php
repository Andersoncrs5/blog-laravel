<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PostSeed extends Seeder
{
    public function run(): void
    {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur eius magnam excepturi neque unde officia rem provident eaque, dolore molestias voluptatibus ea. Veniam, alias minus ullam maiores distinctio sed vitae!';

        for ($i = 0; $i < 500; $i++) { 
            DB::table('posts')->insert([
                'id' => Str::uuid(), 
                'title' => "Title of post $i",
                'content' => substr($lorem, 0, rand(10, strlen($lorem))), // Gera um trecho aleatório do lorem
                'category_id' => 1,
                'user_id' => rand(1, 100), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
