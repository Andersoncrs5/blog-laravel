<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InitSeed extends Seeder
{
    public function run(): void
    {
        // Usuários admin
        for ($i = 0; $i < 15; $i++) {
            DB::table('user')->insert([
                'name' => 'Admin User' . $i,
                'email' => 'admin' . $i . '@example.com',
                'password' => Hash::make('12345678', ['rounds' => 4]),
                'is_adm' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Usuários comuns
        for ($i = 0; $i < 150; $i++) {
            DB::table('user')->insert([
                'name' => 'user' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('12345678'),
                'is_adm' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Categorias
        for ($i = 0; $i < 15; $i++) {
            DB::table('categories')->insert([
                'name' => 'category ' . $i,
                'is_active' => true,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur eius magnam excepturi neque unde officia rem provident eaque, dolore molestias voluptatibus ea. Veniam, alias minus ullam maiores distinctio sed vitae!';

        // POSTS
        $postIds = [];

        for ($i = 0; $i < 600; $i++) {
            $uuid = $this->generateUniqueUuid('posts');
            $postIds[] = $uuid;

            DB::table('posts')->insert([
                'id' => $uuid,
                'title' => "Title of post $i",
                'content' => substr($lorem, 0, rand(10, strlen($lorem))),
                'category_id' => rand(1, 15),
                'user_id' => rand(1, 150),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // COMMENTS
        $commentIds = [];

        for ($i = 0; $i < 1000000; $i++) {
            $uuid = $this->generateUniqueUuid('comments');
            $commentIds[] = $uuid;

            DB::table('comments')->insert([
                'id' => $uuid,
                'content' => substr($lorem, 0, rand(10, strlen($lorem))),
                'user_id' => rand(1, 150),
                'post_id' => $postIds[array_rand($postIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 0; $i < 10000000; $i++) {
            $uuid = $this->generateUniqueUuid('comments');

            DB::table('comments')->insert([
                'id' => $uuid,
                'content' => substr($lorem, 0, rand(3, strlen($lorem))),
                'user_id' => rand(1, 150),
                'post_id' => $postIds[array_rand($postIds)],
                'parent_id' => $commentIds[array_rand($commentIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Exemplo de favorite_posts (desativado por padrão)
        // for ($i = 0; $i < 1000; $i++) {
        //     DB::table('favorite_posts')->insert([
        //         'user_id' => rand(1, 150),
        //         'post_id' => $postIds[array_rand($postIds)],
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
    }

    private function generateUniqueUuid(string $table, string $column = 'id')
    {
        do {
            $uuid = Str::uuid();
            $exists = DB::table($table)->where($column, $uuid)->exists();
        } while ($exists);

        return $uuid;
    }
}
