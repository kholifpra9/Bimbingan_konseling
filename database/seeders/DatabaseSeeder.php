<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            GuruBkSeeder::class,
            SiswaSeeder::class,
            KepalaSekolahSeeder::class,
            KetuaJurusanSeeder::class,
            KesiswaanSeeder::class,
            OrangTuaSeeder::class,
        ]);
    }
}
