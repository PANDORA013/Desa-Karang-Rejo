<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@desakarangrejo.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
            'phone' => '081234567890',
            'bio' => 'Administrator sistem website Desa Karangrejo',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Operator Desa',
            'email' => 'operator@desakarangrejo.id',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'status' => 'active',
            'phone' => '081234567891',
            'bio' => 'Operator website Desa Karangrejo',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Kepala Desa',
            'email' => 'kades@desakarangrejo.id',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'status' => 'active',
            'phone' => '081234567892',
            'bio' => 'Kepala Desa Karangrejo',
            'email_verified_at' => now(),
        ]);
    }
}