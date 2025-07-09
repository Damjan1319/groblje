@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Izmena uplate</h2>
    <form action="{{ route('uplata.update', $uplata->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="grobno_mesto_id" class="block text-gray-700">Grobno mesto</label>
            <select name="grobno_mesto_id" id="grobno_mesto_id" class="form-select mt-1 block w-full">
                @foreach($grobnaMesta as $gm)
                    <option value="{{ $gm->id }}" {{ $uplata->grobno_mesto_id == $gm->id ? 'selected' : '' }}>{{ $gm->sifra }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="uplatilac_id" class="block text-gray-700">Uplatilac</label>
            <select name="uplatilac_id" id="uplatilac_id" class="form-select mt-1 block w-full">
                @foreach($uplatilaci as $u)
                    <option value="{{ $u->id }}" {{ $uplata->uplatilac_id == $u->id ? 'selected' : '' }}>{{ $u->ime_prezime }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="za_koga" class="block text-gray-700">Za koga (preminuli)</label>
            <input type="text" name="za_koga" id="za_koga" class="form-input mt-1 block w-full" value="{{ old('za_koga', $uplata->za_koga) }}">
        </div>
        <div class="mb-4">
            <label for="iznos" class="block text-gray-700">Iznos</label>
            <input type="number" step="0.01" name="iznos" id="iznos" class="form-input mt-1 block w-full" value="{{ old('iznos', $uplata->iznos) }}">
        </div>
        <div class="mb-4">
            <label for="period" class="block text-gray-700">Period</label>
            <input type="text" name="period" id="period" class="form-input mt-1 block w-full" value="{{ old('period', $uplata->period) }}">
        </div>
        <div class="mb-4">
            <label for="datum_uplate" class="block text-gray-700">Datum uplate</label>
            <input type="date" name="datum_uplate" id="datum_uplate" class="form-input mt-1 block w-full" value="{{ old('datum_uplate', $uplata->datum_uplate ? $uplata->datum_uplate->format('Y-m-d') : '') }}">
        </div>
        <div class="mb-4">
            <label for="napomena" class="block text-gray-700">Napomena</label>
            <textarea name="napomena" id="napomena" class="form-input mt-1 block w-full">{{ old('napomena', $uplata->napomena) }}</textarea>
        </div>
        <div class="mb-4 flex items-center">
            <input type="checkbox" name="uplaceno" id="uplaceno" value="1" {{ old('uplaceno', $uplata->uplaceno) ? 'checked' : '' }}>
            <label for="uplaceno" class="ml-2 text-gray-700">Uplaćeno</label>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Sačuvaj izmene</button>
        </div>
    </form>
</div>
@endsection 