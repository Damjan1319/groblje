<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🏛️ Detalji grobnog mesta
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('grobno-mesto.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Nazad
                </a>
                @auth
                    @if(auth()->user()->canEdit())
                        <a href="{{ route('grobno-mesto.edit', $grobnoMesto) }}" 
                           class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            ✏️ Izmeni
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Osnovni podaci</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-700">Šifra:</span>
                                    <span class="ml-2 text-gray-900">{{ $grobnoMesto->sifra }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Oznaka:</span>
                                    <span class="ml-2 text-gray-900">{{ $grobnoMesto->oznaka }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Lokacija:</span>
                                    <span class="ml-2 text-gray-900">{{ $grobnoMesto->lokacija ?? 'Nije uneto' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Uplatilac:</span>
                                    <span class="ml-2 text-gray-900">{{ $grobnoMesto->uplatilac->ime_prezime ?? 'Nije dodeljen' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Napomena:</span>
                                    <span class="ml-2 text-gray-900">{{ $grobnoMesto->napomena ?? 'Nema napomene' }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">👥 Preminuli</h3>
                            @if($grobnoMesto->preminuli->count() > 0)
                                <div class="space-y-2">
                                    @foreach($grobnoMesto->preminuli as $preminuli)
                                        <div class="border border-gray-200 rounded p-3">
                                            <div class="font-medium text-gray-900">
                                                {{ $preminuli->ime_prezime }}
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                {{ $preminuli->datum_rodjenja ? $preminuli->datum_rodjenja->format('d.m.Y') : 'N/A' }} - 
                                                {{ $preminuli->datum_smrti ? $preminuli->datum_smrti->format('d.m.Y') : 'N/A' }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">Nema preminulih na ovom grobnom mestu.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">💰 Uplate</h3>
                            @auth
                                @if(auth()->user()->canEdit())
                                    <a href="{{ route('grobno-mesto.uplata.create', $grobnoMesto->id) }}" 
                                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        ➕ Dodaj uplatu
                                    </a>
                                @endif
                            @endauth
                        </div>
                        @if($grobnoMesto->uplate->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uplatilac</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Za koga</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Iznos</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($grobnoMesto->uplate as $uplata)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $uplata->uplatilac->ime_prezime ?? 'N/A' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $uplata->za_koga }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $uplata->period }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-green-600">{{ number_format($uplata->iznos, 2) }} RSD</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $uplata->datum_uplate ? $uplata->datum_uplate->format('d.m.Y') : 'N/A' }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">Nema uplata za ovo grobno mesto.</p>
                        @endif
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm text-gray-500">Ukupno uplata:</span>
                                <span class="ml-2 font-bold text-lg text-green-600">
                                    {{ number_format($grobnoMesto->uplate->sum('iznos'), 2) }} RSD
                                </span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Broj preminulih:</span>
                                <span class="ml-2 font-bold text-lg text-blue-600">
                                    {{ $grobnoMesto->preminuli->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 