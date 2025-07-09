<?php

namespace App\Http\Controllers;

use App\Models\Uplata;
use App\Models\GrobnoMesto;
use App\Models\Uplatilac;
use App\Models\Preminuli;

class StatistikaController extends Controller
{
    public function index()
    {
        $statistika = [
            'ukupno_uplata' => Uplata::count(),
            'ukupan_iznos' => Uplata::sum('iznos'),
            'uplaceno' => Uplata::where('uplaceno', true)->count(),
            'neuplaceno' => Uplata::where('uplaceno', false)->count(),
            'ukupno_grobnih_mesta' => GrobnoMesto::count(),
            'ukupno_uplatilaca' => Uplatilac::count(),
            'ukupno_preminulih' => Uplatilac::whereNotNull('imePreminulog')->whereNotNull('prezimePreminulog')->count(),
        ];
        return view('statistika.index', compact('statistika'));
    }
} 