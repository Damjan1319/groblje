<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrobnoMesto;
use App\Models\Uplatilac;
use App\Models\Preminuli;
use App\Models\Uplata;

class SearchController extends Controller
{
    public function __construct()
    {
        // Search je dostupan svima, bez autentifikacije
    }

    public function index()
    {
        $query = GrobnoMesto::with(['preminuli', 'uplate', 'uplatilacs']);

        // Filter po imenu ili prezimenu preminulog ili uplatioca
        if (request('ime_prezime')) {
            $imePrezime = request('ime_prezime');
            $query->whereHas('preminuli', function($q) use ($imePrezime) {
                $q->where('ime_prezime', 'like', "%$imePrezime%") ;
            })
            ->orWhereHas('uplatilacs', function($q) use ($imePrezime) {
                $q->where('ime_prezime', 'like', "%$imePrezime%")
                  ->orWhere('adresa', 'like', "%$imePrezime%") ;
            });
        }

        // Filter po nazivu (šifri) grobnog mesta
        if (request('sifra')) {
            $query->where('sifra', 'like', '%' . request('sifra') . '%');
        }

        // Filter po statusu uplate
        if (request('status') === 'uplaceno') {
            $query->whereHas('uplate', function($q) {
                $q->where('uplaceno', true);
            });
        } elseif (request('status') === 'neuplaceno') {
            $query->whereDoesntHave('uplate', function($q) {
                $q->where('uplaceno', true);
            });
        }

        // Filter po oznaci
        if (request('oznaka')) {
            $query->where('oznaka', 'like', '%' . request('oznaka') . '%');
        }

        // Filter po lokaciji
        if (request('lokacija')) {
            $query->where('lokacija', 'like', '%' . request('lokacija') . '%');
        }

        $grobnaMesta = $query->orderBy('sifra', 'asc')->paginate(15);

        return view('search.index', compact('grobnaMesta'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type', 'all');

        $results = collect();

        if ($type === 'all' || $type === 'grobno_mesto') {
            $grobnaMesta = GrobnoMesto::where('sifra', 'like', "%{$query}%")
                ->orWhere('oznaka', 'like', "%{$query}%")
                ->orWhere('lokacija', 'like', "%{$query}%")
                ->with(['preminuli', 'uplate'])
                ->get();
            $results = $results->merge($grobnaMesta);
        }

        if ($type === 'all' || $type === 'uplatilac') {
            $uplatilaci = Uplatilac::where('ime_prezime', 'like', "%{$query}%")
                ->orWhere('adresa', 'like', "%{$query}%")
                ->with('uplate')
                ->get();
            $results = $results->merge($uplatilaci);
        }

        if ($type === 'all' || $type === 'preminuli') {
            $preminuli = Preminuli::where('ime_prezime', 'like', "%{$query}%")
                ->with(['grobnoMesto', 'uplate'])
                ->get();
            $results = $results->merge($preminuli);
        }

        if ($type === 'all' || $type === 'uplata') {
            $uplate = Uplata::where('period', 'like', "%{$query}%")
                ->orWhere('napomena', 'like', "%{$query}%")
                ->with(['grobnoMesto', 'uplatilac'])
                ->get();
            $results = $results->merge($uplate);
        }

        return view('search.results', compact('results', 'query', 'type'));
    }
}
