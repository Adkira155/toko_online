<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //====== seeder akun - user ======
        DB::table('users')->insert([
            [
                'name' => 'Admin Test',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'), // Gunakan Hash untuk mengenkripsi password
                'role' => 'admin', // Set role ke admin
                'alamat' => '-',
                'nomor' => 0,
                'email_verified_at' => now(),
                'social_id' => null,
                'social_type' => null,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'juna',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user1234'), // Gunakan Hash untuk mengenkripsi password
                'role' => 'user', // Set role ke admin
                'alamat' => '-',
                'nomor' => 0,
                'email_verified_at' => now(),
                'social_id' => null,
                'social_type' => null,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'junta',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('user1234'), // Gunakan Hash untuk mengenkripsi password
                'role' => 'user', // Set role ke admin
                'alamat' => '-',
                'nomor' => 0,
                'email_verified_at' => now(),
                'social_id' => null,
                'social_type' => null,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
