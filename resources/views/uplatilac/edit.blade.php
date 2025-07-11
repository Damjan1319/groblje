<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Izmeni uplatioca
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('uplatilac.update', $uplatilac) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-input-label for="ime_prezime" value="Ime i prezime uplatioca" />
                                <x-text-input id="ime_prezime" name="ime_prezime" type="text" class="mt-1 block w-full" 
                                             value="{{ old('ime_prezime', $uplatilac->ime_prezime) }}" required autofocus />
                                <x-input-error :messages="$errors->get('ime_prezime')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="adresa" value="Adresa" />
                                <x-text-input id="adresa" name="adresa" type="text" class="mt-1 block w-full" 
                                             value="{{ old('adresa', $uplatilac->adresa) }}" required />
                                <x-input-error :messages="$errors->get('adresa')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="telefon" value="Telefon" />
                                <x-text-input id="telefon" name="telefon" type="text" class="mt-1 block w-full" 
                                             value="{{ old('telefon', $uplatilac->telefon) }}" />
                                <x-input-error :messages="$errors->get('telefon')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="imePreminulog" value="Ime preminulog" />
                                <x-text-input id="imePreminulog" name="imePreminulog" type="text" class="mt-1 block w-full" 
                                             value="{{ old('imePreminulog', $uplatilac->imePreminulog) }}" />
                                <x-input-error :messages="$errors->get('imePreminulog')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="prezimePreminulog" value="Prezime preminulog" />
                                <x-text-input id="prezimePreminulog" name="prezimePreminulog" type="text" class="mt-1 block w-full" 
                                             value="{{ old('prezimePreminulog', $uplatilac->prezimePreminulog) }}" />
                                <x-input-error :messages="$errors->get('prezimePreminulog')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-input-label for="grobna_mesta" value="Grobna mesta (možete izabrati više)" />
                            @php $grobnaMesta = $grobnaMesta ?? \App\Models\GrobnoMesto::all(); @endphp
                            <select id="grobna_mesta" name="grobna_mesta[]" class="mt-1 block w-full" multiple>
                                @foreach($grobnaMesta as $gm)
                                    <option value="{{ $gm->id }}" @if(in_array($gm->id, old('grobna_mesta', $uplatilac->grobnaMesta->pluck('id')->toArray()))) selected @endif>
                                        {{ $gm->sifra }} - {{ $gm->oznaka }} ({{ $gm->lokacija }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('grobna_mesta')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <a href="{{ route('uplatilac.show', $uplatilac) }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                ❌ Otkaži
                            </a>
                            <x-primary-button>
                                💾 Sačuvaj izmene
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 