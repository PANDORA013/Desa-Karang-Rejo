<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            // VillageDataSeeder::class,  // Dinonaktifkan karena menggunakan UpdateVillageDataSeeder
            UpdateVillageDataSeeder::class,
            PageSeeder::class,
            AnnouncementSeeder::class,
            PostSeeder::class,
        ]);
    }
}