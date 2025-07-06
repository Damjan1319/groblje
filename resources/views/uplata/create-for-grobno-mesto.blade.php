<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold">💰 Dodaj uplatu</h1>
                        <p class="text-green-100 mt-1">Grobno mesto: {{ $grobnoMesto->sifra }} ({{ $grobnoMesto->oznaka }})</p>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('grobno-mesto.show', $grobnoMesto->id) }}" 
                           class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            ← Nazad na detalje
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Informacije o grobnom mestu -->
            <div class="mb-8 bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <span class="mr-2">🏛️</span>
                    Informacije o grobnom mestu
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded">
                        <div class="text-sm font-medium text-gray-500">Šifra</div>
                        <div class="text-lg font-bold text-gray-900">{{ $grobnoMesto->sifra }}</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <div class="text-sm font-medium text-gray-500">Oznaka</div>
                        <div class="text-lg font-bold text-gray-900">{{ $grobnoMesto->oznaka }}</div>
                    </div>
                    @if($grobnoMesto->lokacija)
                    <div class="bg-gray-50 p-3 rounded">
                        <div class="text-sm font-medium text-gray-500">Lokacija</div>
                        <div class="text-lg font-bold text-gray-900">{{ $grobnoMesto->lokacija }}</div>
                    </div>
                    @endif
                    @if($grobnoMesto->uplatilac)
                    <div class="bg-gray-50 p-3 rounded">
                        <div class="text-sm font-medium text-gray-500">Trenutni uplatilac</div>
                        <div class="text-lg font-bold text-gray-900">{{ $grobnoMesto->uplatilac->ime_prezime }}</div>
                        <div class="text-sm text-gray-600">{{ $grobnoMesto->uplatilac->adresa }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Forma za uplatu -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">📝 Unesite podatke o uplati</h3>
                </div>
                
                <form method="POST" action="{{ route('grobno-mesto.uplata.store', $grobnoMesto->id) }}" class="p-6 space-y-6">
                    @csrf

                    <!-- Uplatilac -->
                    <div>
                        <label for="uplatilac_id" class="block text-sm font-medium text-gray-700 mb-2">
                            👤 Uplatilac *
                        </label>
                        <select id="uplatilac_id" name="uplatilac_id" 
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <option value="">Izaberite uplatioca</option>
                            @foreach($uplatilaci as $uplatilac)
                                <option value="{{ $uplatilac->id }}" {{ old('uplatilac_id') == $uplatilac->id ? 'selected' : '' }}>
                                    {{ $uplatilac->ime_prezime }} - {{ $uplatilac->adresa }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('uplatilac_id')" class="mt-2" />
                    </div>

                    <!-- Za koga -->
                    <div>
                        <label for="za_koga" class="block text-sm font-medium text-gray-700 mb-2">
                            👤 Za koga je uplata *
                        </label>
                        <input list="preminuli-list" id="za_koga" name="za_koga" 
                               class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                               placeholder="Izaberite ili upišite ime preminulog" value="{{ old('za_koga') }}" required>
                        <datalist id="preminuli-list">
                            @foreach($preminuli as $p)
                                <option value="{{ $p->ime_prezime }}">
                            @endforeach
                        </datalist>
                        <x-input-error :messages="$errors->get('za_koga')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Iznos -->
                        <div>
                            <label for="iznos" class="block text-sm font-medium text-gray-700 mb-2">
                                💰 Iznos (RSD) *
                            </label>
                            <input type="number" id="iznos" name="iznos" step="0.01" 
                                   class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                   placeholder="0.00" value="{{ old('iznos') }}" required>
                            <x-input-error :messages="$errors->get('iznos')" class="mt-2" />
                        </div>

                        <!-- Period -->
                        <div>
                            <label for="period" class="block text-sm font-medium text-gray-700 mb-2">
                                📅 Period *
                            </label>
                            <input type="text" id="period" name="period" 
                                   class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                   placeholder="npr. 2024-2025" value="{{ old('period') }}" required>
                            <x-input-error :messages="$errors->get('period')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Datum uplate -->
                        <div>
                            <label for="datum_uplate" class="block text-sm font-medium text-gray-700 mb-2">
                                📅 Datum uplate
                            </label>
                            <input type="date" id="datum_uplate" name="datum_uplate" 
                                   class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                   value="{{ old('datum_uplate') }}">
                            <x-input-error :messages="$errors->get('datum_uplate')" class="mt-2" />
                        </div>

                        <!-- Uplaćeno -->
                        <div class="flex items-center justify-center">
                            <div class="flex items-center h-5">
                                <input id="uplaceno" type="checkbox" name="uplaceno" value="1" 
                                       {{ old('uplaceno') ? 'checked' : '' }} 
                                       class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                <label for="uplaceno" class="ml-3 text-sm font-medium text-gray-700">
                                    ✅ Uplaćeno
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Napomena -->
                    <div>
                        <label for="napomena" class="block text-sm font-medium text-gray-700 mb-2">
                            📝 Napomena
                        </label>
                        <textarea id="napomena" name="napomena" rows="3" 
                                  class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                  placeholder="Dodatne napomene o uplati...">{{ old('napomena') }}</textarea>
                        <x-input-error :messages="$errors->get('napomena')" class="mt-2" />
                    </div>

                    <!-- Dugmad -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('grobno-mesto.show', $grobnoMesto->id) }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            ❌ Otkaži
                        </a>
                        <button type="submit" 
                                class="bg-green-500 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            💾 Sačuvaj uplatu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 