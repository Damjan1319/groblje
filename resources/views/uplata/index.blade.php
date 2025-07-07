<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sve uplate
            </h2>
            @auth
                @if(auth()->user()->canAdd())
                    <a href="{{ route('uplata.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Dodaj uplatu
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter forma -->
            <form method="GET" action="{{ route('uplata.index') }}" class="mb-6 bg-white p-4 rounded shadow flex flex-col md:flex-row md:items-end gap-4">
                <div class="flex-1">
                    <x-input-label for="ime_prezime" value="Ime i prezime uplatioca" />
                    <x-text-input id="ime_prezime" name="ime_prezime" type="text" class="mt-1 block w-full" value="{{ request('ime_prezime') }}" placeholder="Unesi ime ili prezime..." />
                </div>
                <div class="flex-1">
                    <x-input-label for="sifra_grobnog_mesta" value="Šifra grobnog mesta" />
                    <x-text-input id="sifra_grobnog_mesta" name="sifra_grobnog_mesta" type="text" class="mt-1 block w-full" value="{{ request('sifra_grobnog_mesta') }}" placeholder="Unesi šifru..." />
                </div>
                <div class="flex-1">
                    <x-input-label for="status" value="Status uplate" />
                    <select id="status" name="status" class="mt-1 block w-full rounded border-gray-300">
                        <option value="">Svi</option>
                        <option value="uplaceno" {{ request('status') == 'uplaceno' ? 'selected' : '' }}>Uplaćeno</option>
                        <option value="neuplaceno" {{ request('status') == 'neuplaceno' ? 'selected' : '' }}>Neuplaćeno</option>
                    </select>
                </div>
                <div>
                    <x-primary-button class="w-full md:w-auto">Pretraži</x-primary-button>
                </div>
            </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($uplate->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Šifra uplate</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ime i prezime uplatioca</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Adresa uplatioca</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Šifra grobnog mesta</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Za koga (preminuli)</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Iznos</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Plaćeno</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Datum uplate</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Napomena</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Akcije</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($uplate as $uplata)
                                        <tr>
                                            <td class="px-4 py-2">{{ $uplata->id }}</td>
                                            <td class="px-4 py-2">{{ $uplata->uplatilac->ime_prezime ?? '-' }}</td>
                                            <td class="px-4 py-2">{{ $uplata->uplatilac->adresa ?? '-' }}</td>
                                            <td class="px-4 py-2">{{ $uplata->grobnoMesto->sifra ?? '-' }}</td>
                                            <td class="px-4 py-2">{{ $uplata->za_koga }}</td>
                                            <td class="px-4 py-2 font-bold text-green-600">{{ number_format($uplata->iznos, 2) }} RSD</td>
                                            <td class="px-4 py-2">
                                                @if($uplata->uplaceno)
                                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Da</span>
                                                @else
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Ne</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2">{{ $uplata->period }}</td>
                                            <td class="px-4 py-2">{{ $uplata->datum_uplate ? $uplata->datum_uplate->format('d.m.Y') : '-' }}</td>
                                            <td class="px-4 py-2">{{ $uplata->napomena ?? '-' }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('uplata.show', $uplata) }}" 
                                                       class="text-blue-600 hover:text-blue-900">Pregled</a>
                                                    @auth
                                                        @if(auth()->user()->canEdit())
                                                            <a href="{{ route('uplata.edit', $uplata) }}" 
                                                               class="text-yellow-600 hover:text-yellow-900">Izmeni</a>
                                                        @endif
                                                        @if(auth()->user()->canDelete())
                                                            <form action="{{ route('uplata.destroy', $uplata) }}" 
                                                                  method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                                        onclick="return confirm('Da li ste sigurni da želite da obrišete ovu uplatu?')">
                                                                    Obriši
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $uplate->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-4xl mb-4 text-gray-400">Uplate</div>
                            <h3 class="text-2xl font-bold text-gray-700 mb-2">Nema uplata</h3>
                            <p class="text-gray-500 mb-6">Još uvek nije kreirana nijedna uplata.</p>
                            @auth
                                @if(auth()->user()->canAdd())
                                    <a href="{{ route('uplata.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Dodaj prvu uplatu
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
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