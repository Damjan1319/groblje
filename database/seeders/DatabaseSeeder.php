<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Pozivamo sve seedere u pravom redosledu
        $this->call([
            UserSeeder::class,
            GrobnoMestoReplaceSeeder::class,
            UplatilacReplaceSeeder::class,
            UplatilacGrobnoMestoPivotSeeder::class,
            UplataReplaceSeeder::class,
        ]);
    }
}
