<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrobnoMesto;
use Barryvdh\DomPDF\Facade\Pdf;

class GrobnoMestoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grobnaMesta = GrobnoMesto::with(['preminuli', 'uplate'])->paginate(15);
        return view('grobno-mesto.index', compact('grobnaMesta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->canAdd()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za kreiranje grobnih mesta.');
        }
        $uplatilaci = \App\Models\Uplatilac::all();
        return view('grobno-mesto.create', compact('uplatilaci'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->canAdd()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za kreiranje grobnih mesta.');
        }

        $request->validate([
            'sifra' => 'required|unique:grobno_mestos,sifra',
            'oznaka' => 'required|unique:grobno_mestos,oznaka',
            'lokacija' => 'nullable|string',
            'napomena' => 'nullable|string',
        ]);

        GrobnoMesto::create($request->all());

        return redirect()->route('grobno-mesto.index')->with('success', 'Grobno mesto je uspešno kreirano.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $grobnoMesto = GrobnoMesto::with(['preminuli', 'uplate'])->findOrFail($id);
        return view('grobno-mesto.show', compact('grobnoMesto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->canEdit()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za izmenu grobnih mesta.');
        }

        $grobnoMesto = GrobnoMesto::findOrFail($id);
        $uplatilaci = \App\Models\Uplatilac::all();
        return view('grobno-mesto.edit', compact('grobnoMesto', 'uplatilaci'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->user()->canEdit()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za izmenu grobnih mesta.');
        }

        $grobnoMesto = GrobnoMesto::findOrFail($id);

        $request->validate([
            'sifra' => 'required|unique:grobno_mestos,sifra,' . $id,
            'oznaka' => 'required|unique:grobno_mestos,oznaka,' . $id,
            'lokacija' => 'nullable|string',
            'napomena' => 'nullable|string',
        ]);

        $grobnoMesto->update($request->all());

        return redirect()->route('grobno-mesto.index')->with('success', 'Grobno mesto je uspešno ažurirano.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->canDelete()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za brisanje grobnih mesta.');
        }

        $grobnoMesto = GrobnoMesto::findOrFail($id);
        $grobnoMesto->delete();

        return redirect()->route('grobno-mesto.index')->with('success', 'Grobno mesto je uspešno obrisano.');
    }

    /**
     * Generate PDF report for the specified resource.
     */
    public function pdf(string $id)
    {
        $grobnoMesto = GrobnoMesto::with(['preminuli', 'uplate', 'uplatilac'])->findOrFail($id);
        $pdf = Pdf::loadView('grobno-mesto.pdf', compact('grobnoMesto'));
        return $pdf->download('grobno-mesto-'.$grobnoMesto->sifra.'.pdf');
    }
}
