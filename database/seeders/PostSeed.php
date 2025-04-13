<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

//php artisan db:seed --class=PostSeed
class PostSeed extends Seeder
{
    public function run(): void
    {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur eius magnam excepturi neque unde officia rem provident eaque, dolore molestias voluptatibus ea. Veniam, alias minus ullam maiores distinctio sed vitae!';

        for ($i = 0; $i < 1_000_000; $i++) { 
            $uuid = $this->generateUniqueUuid('posts');
            $postIds[] = $uuid;

            DB::table('posts')->insert([
                'id' => $uuid, 
                'title' => "Title of post $i",
                'content' => substr($lorem, 0, rand(5, strlen($lorem))),
                'category_id' => 1,
                'user_id' => rand(15, 165), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
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
