<?php

namespace Database\Seeders;

use App\Models\UserMetricModel;
use App\Models\UserModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// php artisan db:seed --class=AdmSeed
class AdmSeed extends Seeder
{
    public function run(): void
    {
        
        for ($i = 1; $i <= 15; $i++) {
            $user = UserModel::create([
                'name' => 'Admin User' . $i,
                'email' => 'admin' . $i . '@example.com',
                'password' => Hash::make('12345678', ['rounds' => 4]),
                'is_adm' => true,
            ]);
            
            UserMetricModel::create([
                'user_id' => $user->id, 
            ]);
        }
    }
}
