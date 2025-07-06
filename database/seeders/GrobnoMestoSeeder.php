<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GrobnoMesto;

class GrobnoMestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grobnaMesta = [
            [
                'sifra' => '0001',
                'oznaka' => 'gm01',
                'lokacija' => 'Sekcija A, red 1',
                'napomena' => 'Staro groblje'
            ],
            [
                'sifra' => '0002',
                'oznaka' => 'gm02',
                'lokacija' => 'Sekcija A, red 1',
                'napomena' => 'Staro groblje'
            ],
            [
                'sifra' => '0003',
                'oznaka' => 'gm03',
                'lokacija' => 'Sekcija A, red 2',
                'napomena' => 'Staro groblje'
            ],
            [
                'sifra' => '0004',
                'oznaka' => 'gm04',
                'lokacija' => 'Sekcija A, red 2',
                'napomena' => 'Staro groblje'
            ],
            [
                'sifra' => '0005',
                'oznaka' => 'gm05',
                'lokacija' => 'Sekcija B, red 1',
                'napomena' => 'Novo groblje'
            ],
            [
                'sifra' => '0006',
                'oznaka' => 'gm06',
                'lokacija' => 'Sekcija B, red 1',
                'napomena' => 'Novo groblje'
            ],
            [
                'sifra' => '0007',
                'oznaka' => 'gm07',
                'lokacija' => 'Sekcija B, red 2',
                'napomena' => 'Novo groblje'
            ],
            [
                'sifra' => '0008',
                'oznaka' => 'gm08',
                'lokacija' => 'Sekcija B, red 2',
                'napomena' => 'Novo groblje'
            ],
        ];

        foreach ($grobnaMesta as $grobnoMesto) {
            GrobnoMesto::create($grobnoMesto);
        }
    }
}
