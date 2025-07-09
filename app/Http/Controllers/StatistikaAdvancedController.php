<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uplata;
use Carbon\Carbon;

class StatistikaAdvancedController extends Controller
{
    public function index(Request $request)
    {
        $godine = Uplata::selectRaw("strftime('%Y', datum_uplate) as godina")->distinct()->orderBy('godina', 'desc')->pluck('godina');
        $meseci = [
            1 => 'Januar', 2 => 'Februar', 3 => 'Mart', 4 => 'April', 5 => 'Maj', 6 => 'Jun',
            7 => 'Jul', 8 => 'Avgust', 9 => 'Septembar', 10 => 'Oktobar', 11 => 'Novembar', 12 => 'Decembar'
        ];

        $izabraneGodine = $request->input('godine', []);
        $izabraniMeseci = $request->input('meseci', []);

        $query = Uplata::query();
        if (!empty($izabraneGodine)) {
            $query->whereIn(\DB::raw("strftime('%Y', datum_uplate)"), $izabraneGodine);
        }
        if (!empty($izabraniMeseci)) {
            $meseciStr = array_map(function($m) { return str_pad($m, 2, '0', STR_PAD_LEFT); }, $izabraniMeseci);
            $query->whereIn(\DB::raw("strftime('%m', datum_uplate)"), $meseciStr);
        }
        $uplate = $query->get();

        // Grupisanje za grafik
        $statistika = [];
        foreach ($uplate as $uplata) {
            $godina = Carbon::parse($uplata->datum_uplate)->year;
            $mesec = Carbon::parse($uplata->datum_uplate)->month;
            $key = $godina . '-' . $mesec;
            if (!isset($statistika[$key])) {
                $statistika[$key] = [
                    'godina' => $godina,
                    'mesec' => $mesec,
                    'broj' => 0,
                    'suma' => 0,
                ];
            }
            $statistika[$key]['broj']++;
            $statistika[$key]['suma'] += $uplata->iznos;
        }

        return view('statistika.napredna', [
            'godine' => $godine,
            'meseci' => $meseci,
            'izabraneGodine' => $izabraneGodine,
            'izabraniMeseci' => $izabraniMeseci,
            'statistika' => $statistika,
        ]);
    }
} 