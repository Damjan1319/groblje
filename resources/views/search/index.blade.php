<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @guest
                <!-- Dugme za prijavu za goste -->
                <div style="margin-bottom: 1.5rem; background-color: #fef3c7; border: 2px solid #f59e0b; border-radius: 0.5rem; padding: 1rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h3 style="font-size: 1.125rem; font-weight: 600; color: #92400e; margin: 0;">ADMINISTRACIJA</h3>
                            <p style="color: #b45309; font-size: 0.875rem; margin: 0.25rem 0 0 0;">Prijavite se za pristup</p>
                        </div>
                        <a href="{{ route('login') }}" style="background-color: #f59e0b; color: white; padding: 0.5rem 1.5rem; border-radius: 0.5rem; font-weight: 500; text-decoration: none; display: inline-block;">
                            PRIJAVA
                        </a>
                    </div>
                </div>
            @endguest

            <!-- Filter forma -->
            <form method="GET" action="{{ route('search.index') }}" class="mb-6 bg-white p-4 rounded shadow flex flex-col md:flex-row md:items-end gap-4">
                <div class="flex-1">
                    <x-input-label for="ime_prezime" value="Ime ili prezime (preminulog ili uplatioca)" />
                    <x-text-input id="ime_prezime" name="ime_prezime" type="text" class="mt-1 block w-full" value="{{ request('ime_prezime') }}" placeholder="Unesi ime ili prezime..." />
                </div>
                <div class="flex-1">
                    <x-input-label for="sifra" value="Naziv grobnog mesta" />
                    <x-text-input id="sifra" name="sifra" type="text" class="mt-1 block w-full" value="{{ request('sifra') }}" placeholder="Unesi naziv..." />
                </div>
                <div class="flex-1">
                    <x-input-label for="status" value="Status uplate" />
                    <select id="status" name="status" class="mt-1 block w-full rounded border-gray-300">
                        <option value="">Svi</option>
                        <option value="uplaceno" {{ request('status') == 'uplaceno' ? 'selected' : '' }}>Uplaćeni</option>
                        <option value="neuplaceno" {{ request('status') == 'neuplaceno' ? 'selected' : '' }}>Neuplaćeni</option>
                    </select>
                </div>
                <div>
                    <x-primary-button class="w-full md:w-auto">Pretraži</x-primary-button>
                </div>
            </form>

            <!-- Glavna tabela grobnih mesta -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-900">Pregled svih grobnih mesta</h2>
                        @auth
                            @if(auth()->user()->canAdd())
                                <a href="{{ route('grobno-mesto.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                    Dodaj grobno mesto
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                @if($grobnaMesta->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grobno mesto</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uplatilac</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preminuli</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status uplate</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Iznos</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($grobnaMesta as $grobnoMesto)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-4">
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $grobnoMesto->sifra }}</div>
                                                <div class="text-sm text-gray-500">{{ $grobnoMesto->oznaka }}</div>
                                                @if($grobnoMesto->lokacija)
                                                    <div class="text-xs text-gray-400">{{ $grobnoMesto->lokacija }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($grobnoMesto->uplatilacs->count())
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        @foreach($grobnoMesto->uplatilacs as $u)
                                                            {{ $u->ime_prezime }}@if(!$loop->last), @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        @foreach($grobnoMesto->uplatilacs as $u)
                                                            {{ $u->adresa }}@if(!$loop->last), @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">Nije dodeljen</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($grobnoMesto->uplatilacs->count())
                                                <div class="text-sm text-gray-900">
                                                    @foreach($grobnoMesto->uplatilacs as $u)
                                                        {{ $u->imePreminulog }} {{ $u->prezimePreminulog }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($grobnoMesto->uplate->count() > 0)
                                                @php
                                                    $latestUplata = $grobnoMesto->uplate->sortByDesc('datum_uplate')->first();
                                                @endphp
                                                @if($latestUplata->uplaceno)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                                        Uplaćeno
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <span class="w-2 h-2 bg-yellow-400 rounded-full mr-1"></span>
                                                        Neuplaćeno
                                                    </span>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <span class="w-2 h-2 bg-red-400 rounded-full mr-1"></span>
                                                    Nema uplata
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($grobnoMesto->uplate->count() > 0)
                                                <div class="text-sm text-gray-900">{{ $grobnoMesto->uplate->sortByDesc('datum_uplate')->first()->period }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $grobnoMesto->uplate->sortByDesc('datum_uplate')->first()->datum_uplate ? $grobnoMesto->uplate->sortByDesc('datum_uplate')->first()->datum_uplate->format('d.m.Y') : 'N/A' }}
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($grobnoMesto->uplate->count() > 0)
                                                <div class="text-sm font-bold text-green-600">{{ number_format($grobnoMesto->uplate->sum('iznos'), 0) }} RSD</div>
                                                <div class="text-xs text-gray-500">{{ $grobnoMesto->uplate->count() }} uplata</div>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('grobno-mesto.show', $grobnoMesto->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50" 
                                                   title="Pregled detalja">
                                                    Pregled
                                                </a>
                                                @auth
                                                    @if(auth()->user()->canAdd())
                                                        <a href="{{ route('grobno-mesto.uplata.create', $grobnoMesto->id) }}" 
                                                           class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50" 
                                                           title="Dodaj uplatu">
                                                            Uplata
                                                        </a>
                                                    @endif
                                                    @if(auth()->user()->canEdit())
                                                        <a href="{{ route('grobno-mesto.edit', $grobnoMesto->id) }}" 
                                                           class="text-yellow-600 hover:text-yellow-900 p-1 rounded hover:bg-yellow-50" 
                                                           title="Izmeni">
                                                            Izmeni
                                                        </a>
                                                    @endif
                                                @endauth
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 px-6 py-3 border-t border-gray-200">
                        {{ $grobnaMesta->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-4xl mb-4 text-gray-400">Grobna mesta</div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">Nema grobnih mesta</h3>
                        <p class="text-gray-500 mb-6">Još uvek nije kreirano nijedno grobno mesto.</p>
                        @auth
                            @if(auth()->user()->canAdd())
                                <a href="{{ route('grobno-mesto.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                                    Dodaj prvo grobno mesto
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Brzi pregledi -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8">
                <a href="{{ route('grobno-mesto.index') }}" class="block bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-6 text-center shadow">
                    <div class="text-2xl mb-2 text-blue-600">Grobna mesta</div>
                    <div class="font-bold text-blue-700">Pregled svih grobnih mesta</div>
                </a>
                <a href="{{ route('uplatilac.index') }}" class="block bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-6 text-center shadow">
                    <div class="text-2xl mb-2 text-green-600">Uplatioci</div>
                    <div class="font-bold text-green-700">Pregled svih uplatioca</div>
                </a>
                <a href="{{ route('preminuli.index') }}" class="block bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg p-6 text-center shadow">
                    <div class="text-2xl mb-2 text-gray-600">Preminuli</div>
                    <div class="font-bold text-gray-700">Pregled svih preminulih</div>
                </a>
                <a href="{{ route('uplata.index') }}" class="block bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 rounded-lg p-6 text-center shadow">
                    <div class="text-2xl mb-2 text-yellow-600">Uplate</div>
                    <div class="font-bold text-yellow-700">Pregled svih uplata</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 