<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uplatilac;

class UplatilacController extends Controller
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
        $uplatilaci = Uplatilac::with('uplate')->paginate(15);
        return view('uplatilac.index', compact('uplatilaci'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->canAdd()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za kreiranje uplatioca.');
        }
        $grobnaMesta = \App\Models\GrobnoMesto::all();
        return view('uplatilac.create', compact('grobnaMesta'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->canAdd()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za kreiranje uplatioca.');
        }

        $request->validate([
            'ime_prezime' => 'required|string|max:255',
            'adresa' => 'required|string|max:255',
            'telefon' => 'nullable|string|max:255',
            'imePreminulog' => 'nullable|string|max:255',
            'prezimePreminulog' => 'nullable|string|max:255',
            'grobna_mesta' => 'nullable|array',
            'grobna_mesta.*' => 'exists:grobno_mestos,id',
        ]);

        $uplatilac = Uplatilac::create($request->only(['ime_prezime','adresa','telefon','imePreminulog','prezimePreminulog']));
        if ($request->filled('grobna_mesta')) {
            $uplatilac->grobnaMesta()->sync($request->grobna_mesta);
        }

        return redirect()->route('uplatilac.index')->with('success', 'Uplatilac je uspešno kreiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $uplatilac = Uplatilac::with('uplate')->findOrFail($id);
        return view('uplatilac.show', compact('uplatilac'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->canEdit()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za izmenu uplatioca.');
        }

        $uplatilac = Uplatilac::findOrFail($id);
        $grobnaMesta = \App\Models\GrobnoMesto::all();
        return view('uplatilac.edit', compact('uplatilac', 'grobnaMesta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->user()->canEdit()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za izmenu uplatioca.');
        }

        $uplatilac = Uplatilac::findOrFail($id);
        $request->validate([
            'ime_prezime' => 'required|string|max:255',
            'adresa' => 'required|string|max:255',
            'telefon' => 'nullable|string|max:255',
            'imePreminulog' => 'nullable|string|max:255',
            'prezimePreminulog' => 'nullable|string|max:255',
            'grobna_mesta' => 'nullable|array',
            'grobna_mesta.*' => 'exists:grobno_mestos,id',
        ]);
        $uplatilac->update($request->only(['ime_prezime','adresa','telefon','imePreminulog','prezimePreminulog']));
        $uplatilac->grobnaMesta()->sync($request->grobna_mesta ?? []);
        return redirect()->route('uplatilac.index')->with('success', 'Uplatilac je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->canDelete()) {
            return redirect()->back()->with('error', 'Nemate dozvolu za brisanje uplatioca.');
        }

        $uplatilac = Uplatilac::findOrFail($id);
        $uplatilac->delete();

        return redirect()->route('uplatilac.index')->with('success', 'Uplatilac je uspešno obrisan.');
    }
}
