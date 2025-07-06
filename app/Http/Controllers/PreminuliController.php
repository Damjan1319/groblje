<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preminuli;
use App\Models\GrobnoMesto;

class PreminuliController extends Controller
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
        $preminuli = Preminuli::with(['grobnoMesto', 'uplate'])->paginate(15);
        return view('preminuli.index', compact('preminuli'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->canAdd()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za kreiranje preminulih.');
        }
        
        $grobnaMesta = GrobnoMesto::all();
        return view('preminuli.create', compact('grobnaMesta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->canAdd()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za kreiranje preminulih.');
        }

        $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'datum_rodjenja' => 'nullable|date',
            'datum_smrti' => 'nullable|date',
            'grobno_mesto_id' => 'required|exists:grobno_mestos,id',
            'napomena' => 'nullable|string',
        ]);

        Preminuli::create($request->all());

        return redirect()->route('preminuli.index')->with('success', 'Preminuli je uspešno kreiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $preminuli = Preminuli::with(['grobnoMesto', 'uplate'])->findOrFail($id);
        return view('preminuli.show', compact('preminuli'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->canEdit()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za izmenu preminulih.');
        }

        $preminuli = Preminuli::findOrFail($id);
        $grobnaMesta = GrobnoMesto::all();
        return view('preminuli.edit', compact('preminuli', 'grobnaMesta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->user()->canEdit()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za izmenu preminulih.');
        }

        $preminuli = Preminuli::findOrFail($id);

        $request->validate([
            'ime' => 'required|string|max:255',
            'prezime' => 'required|string|max:255',
            'datum_rodjenja' => 'nullable|date',
            'datum_smrti' => 'nullable|date',
            'grobno_mesto_id' => 'required|exists:grobno_mestos,id',
            'napomena' => 'nullable|string',
        ]);

        $preminuli->update($request->all());

        return redirect()->route('preminuli.index')->with('success', 'Preminuli je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->canDelete()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za brisanje preminulih.');
        }

        $preminuli = Preminuli::findOrFail($id);
        $preminuli->delete();

        return redirect()->route('preminuli.index')->with('success', 'Preminuli je uspešno obrisan.');
    }
}
