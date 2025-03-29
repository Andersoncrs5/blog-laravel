<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Nette\Utils\Random;

class InitSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 10; $i++) { 
            DB::table('user')->insert([
                'name' => 'Admin User' . $i ,
                'email' => 'admin' . $i . '@example.com',
                'password' => Hash::make('12345678'),
                'is_adm' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i=0; $i < 100; $i++) { 
            DB::table('user')->insert([
                'name' => 'user' . $i ,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('12345678'),
                'is_adm' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i=0; $i < 15; $i++) { 
            DB::table('categories')->insert([
                'name' => 'category ' . $i,
                'is_active' => true,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur eius magnam excepturi neque unde officia rem provident eaque, dolore molestias voluptatibus ea. Veniam, alias minus ullam maiores distinctio sed vitae!';

        for ($i = 0; $i < 300; $i++) { 
            DB::table('posts')->insert([
                'id' => Str::uuid(), 
                'title' => "Title of post $i",
                'content' => substr($lorem, 0, rand(10, strlen($lorem))),
                'category_id' => 1,
                'user_id' => rand(1, 100), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}

