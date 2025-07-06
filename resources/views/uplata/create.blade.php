<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Nova uplata
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('uplata.store') }}" method="POST" id="uplata-form">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="grobno_mesto_id" value="Grobno mesto (šifra i oznaka)" />
                                <select id="grobno_mesto_id" name="grobno_mesto_id" class="mt-1 block w-full rounded border-gray-300" required>
                                    <option value="">Izaberi...</option>
                                    @foreach($grobnaMesta as $gm)
                                        <option value="{{ $gm->id }}" data-preminuli="{{ $gm->preminuli->first()->ime_prezime ?? '' }}"
                                            {{ old('grobno_mesto_id') == $gm->id ? 'selected' : '' }}>
                                            {{ $gm->sifra }} - {{ $gm->oznaka }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('grobno_mesto_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="period" value="Period (npr. 2024/2025)" />
                                <x-text-input id="period" name="period" type="text" class="mt-1 block w-full" value="{{ old('period') }}" required />
                                <x-input-error :messages="$errors->get('period')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="iznos" value="Iznos (RSD)" />
                                <x-text-input id="iznos" name="iznos" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('iznos') }}" required />
                                <x-input-error :messages="$errors->get('iznos')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="uplatilac_id" value="Uplatilac" />
                                <select id="uplatilac_id" name="uplatilac_id" class="mt-1 block w-full rounded border-gray-300" required>
                                    <option value="">Izaberi...</option>
                                    @foreach($uplatilaci as $u)
                                        <option value="{{ $u->id }}" {{ old('uplatilac_id') == $u->id ? 'selected' : '' }}>
                                            {{ $u->ime_prezime }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('uplatilac_id')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="za_koga" value="Za koga se uplaćuje (ime i prezime preminulog)" />
                                <x-text-input id="za_koga" name="za_koga" type="text" class="mt-1 block w-full" value="{{ old('za_koga') }}" required />
                                <x-input-error :messages="$errors->get('za_koga')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="datum_uplate" value="Datum uplate" />
                                <x-text-input id="datum_uplate" name="datum_uplate" type="date" class="mt-1 block w-full" value="{{ old('datum_uplate', date('Y-m-d')) }}" />
                                <x-input-error :messages="$errors->get('datum_uplate')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="napomena" value="Napomena (opciono)" />
                                <textarea id="napomena" name="napomena" class="mt-1 block w-full rounded border-gray-300">{{ old('napomena') }}</textarea>
                                <x-input-error :messages="$errors->get('napomena')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <a href="{{ route('uplata.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                ❌ Otkaži
                            </a>
                            <x-primary-button>
                                💾 Sačuvaj
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Automatski popuni "za_koga" na osnovu izabranog grobnog mesta
        document.addEventListener('DOMContentLoaded', function() {
            const grobnoSelect = document.getElementById('grobno_mesto_id');
            const zaKogaInput = document.getElementById('za_koga');
            grobnoSelect.addEventListener('change', function() {
                const selected = grobnoSelect.options[grobnoSelect.selectedIndex];
                const preminuli = selected.getAttribute('data-preminuli');
                if (preminuli) {
                    zaKogaInput.value = preminuli;
                }
            });
        });
    </script>
</x-app-layout> 