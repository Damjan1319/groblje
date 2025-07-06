<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uplata;
use App\Models\GrobnoMesto;
use App\Models\Uplatilac;
use App\Models\Preminuli;

class UplataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Uplata::with(['grobnoMesto', 'uplatilac']);

        if ($request->filled('ime_prezime')) {
            $query->whereHas('uplatilac', function ($q) use ($request) {
                $q->where('ime_prezime', 'like', '%' . $request->ime_prezime . '%');
            });
        }
        if ($request->filled('sifra_grobnog_mesta')) {
            $query->whereHas('grobnoMesto', function ($q) use ($request) {
                $q->where('sifra', 'like', '%' . $request->sifra_grobnog_mesta . '%');
            });
        }
        if ($request->filled('status')) {
            if ($request->status === 'uplaceno') {
                $query->where('uplaceno', true);
            } elseif ($request->status === 'neuplaceno') {
                $query->where('uplaceno', false);
            }
        }

        $uplate = $query->orderByDesc('datum_uplate')->paginate(15)->withQueryString();
        $statistika = [
            'ukupno' => Uplata::count(),
            'ukupan_iznos' => Uplata::sum('iznos'),
            'uplaceno' => Uplata::where('uplaceno', true)->count(),
            'neuplaceno' => Uplata::where('uplaceno', false)->count(),
        ];
        return view('uplata.index', compact('uplate', 'statistika'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->canAdd()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za kreiranje uplata.');
        }
        
        $grobnaMesta = GrobnoMesto::all();
        $uplatilaci = Uplatilac::all();
        return view('uplata.create', compact('grobnaMesta', 'uplatilaci'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->canAdd()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za kreiranje uplata.');
        }

        $request->validate([
            'grobno_mesto_id' => 'required|exists:grobno_mestos,id',
            'uplatilac_id' => 'required|exists:uplatilacs,id',
            'za_koga' => 'required|string|max:255',
            'iznos' => 'required|numeric|min:0',
            'period' => 'required|string|max:255',
            'datum_uplate' => 'nullable|date|before_or_equal:today',
            'napomena' => 'nullable|string',
        ]);

        $uplataData = $request->all();
        $uplataData['uplaceno'] = true; // Automatski postavi status na uplaćeno
        if (empty($uplataData['datum_uplate'])) {
            $uplataData['datum_uplate'] = now()->format('Y-m-d'); // Automatski postavi današnji datum ako nije unet
        }
        Uplata::create($uplataData);

        return redirect()->route('uplata.index')->with('success', 'Uplata je uspešno kreirana.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $uplata = Uplata::with(['grobnoMesto', 'uplatilac', 'preminuli'])->findOrFail($id);
        return view('uplata.show', compact('uplata'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->canEdit()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za izmenu uplata.');
        }

        $uplata = Uplata::findOrFail($id);
        $grobnaMesta = GrobnoMesto::all();
        $uplatilaci = Uplatilac::all();
        $preminuli = Preminuli::all();
        return view('uplata.edit', compact('uplata', 'grobnaMesta', 'uplatilaci', 'preminuli'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->user()->canEdit()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za izmenu uplata.');
        }

        $uplata = Uplata::findOrFail($id);

        $request->validate([
            'grobno_mesto_id' => 'required|exists:grobno_mestos,id',
            'uplatilac_id' => 'required|exists:uplatilacs,id',
            'za_koga' => 'required|string|max:255',
            'iznos' => 'required|numeric|min:0',
            'period' => 'required|string|max:255',
            'datum_uplate' => 'nullable|date|before_or_equal:today',
            'napomena' => 'nullable|string',
        ]);

        $uplata->update($request->all());

        return redirect()->route('uplata.index')->with('success', 'Uplata je uspešno ažurirana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->canDelete()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za brisanje uplata.');
        }

        $uplata = Uplata::findOrFail($id);
        $uplata->delete();

        return redirect()->route('uplata.index')->with('success', 'Uplata je uspešno obrisana.');
    }

    /**
     * Show the form for creating a payment for a specific cemetery plot.
     */
    public function createForGrobnoMesto($grobnoMestoId)
    {
        if (!auth()->user()->canAdd()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za kreiranje uplata.');
        }
        
        $grobnoMesto = GrobnoMesto::with('uplatilac')->findOrFail($grobnoMestoId);
        $uplatilaci = Uplatilac::all();
        $preminuli = \App\Models\Preminuli::all();
        return view('uplata.create-for-grobno-mesto', compact('grobnoMesto', 'uplatilaci', 'preminuli'));
    }

    /**
     * Store a payment for a specific cemetery plot.
     */
    public function storeForGrobnoMesto(Request $request, $grobnoMestoId)
    {
        if (!auth()->user()->canAdd()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za kreiranje uplata.');
        }

        $request->validate([
            'uplatilac_id' => 'required|exists:uplatilacs,id',
            'za_koga' => 'required|string|max:255',
            'iznos' => 'required|numeric|min:0',
            'period' => 'required|string|max:255',
            'datum_uplate' => 'nullable|date|before_or_equal:today',
            'uplaceno' => 'boolean',
            'napomena' => 'nullable|string',
        ]);

        $request->merge(['grobno_mesto_id' => $grobnoMestoId]);
        $uplataData = $request->all();
        $uplataData['uplaceno'] = true; // Automatski postavi status na uplaćeno
        if (empty($uplataData['datum_uplate'])) {
            $uplataData['datum_uplate'] = now()->format('Y-m-d'); // Automatski postavi današnji datum ako nije unet
        }
        Uplata::create($uplataData);

        return redirect()->route('grobno-mesto.show', $grobnoMestoId)->with('success', 'Uplata je uspešno kreirana.');
    }
}
