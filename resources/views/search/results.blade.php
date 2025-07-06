<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🔍 Rezultati pretrage
            </h2>
            <a href="{{ route('search.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Nazad na pretragu
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Pretraženo za: <span class="font-bold text-blue-600">"{{ $query }}"</span></h3>
                    @if($type !== 'all')
                        <p class="text-gray-600">Kategorija: {{ ucfirst(str_replace('_', ' ', $type)) }}</p>
                    @endif
                    <p class="text-gray-700">Pronađeno {{ $results->count() }} rezultata</p>
                </div>
            </div>

            @if($results->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($results as $result)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex items-center mb-4">
                                    @if($result instanceof \App\Models\GrobnoMesto)
                                        <span class="text-2xl mr-2">🏛️</span>
                                        <h3 class="text-lg font-semibold">Grobno mesto</h3>
                                    @elseif($result instanceof \App\Models\Uplatilac)
                                        <span class="text-2xl mr-2">👥</span>
                                        <h3 class="text-lg font-semibold">Uplatilac</h3>
                                    @elseif($result instanceof \App\Models\Preminuli)
                                        <span class="text-2xl mr-2">👤</span>
                                        <h3 class="text-lg font-semibold">Preminuli</h3>
                                    @elseif($result instanceof \App\Models\Uplata)
                                        <span class="text-2xl mr-2">💰</span>
                                        <h3 class="text-lg font-semibold">Uplata</h3>
                                    @endif
                                </div>

                                @if($result instanceof \App\Models\GrobnoMesto)
                                    <h4 class="text-xl font-bold mb-2">{{ $result->sifra }} ({{ $result->oznaka }})</h4>
                                    @if($result->lokacija)
                                        <p class="text-gray-600 mb-2">{{ $result->lokacija }}</p>
                                    @endif
                                    @if($result->napomena)
                                        <p class="text-sm text-gray-500 mb-3">{{ $result->napomena }}</p>
                                    @endif
                                    <div class="flex space-x-2">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $result->preminuli->count() }} preminulih</span>
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $result->uplate->count() }} uplata</span>
                                    </div>
                                    
                                @elseif($result instanceof \App\Models\Uplatilac)
                                    <h4 class="text-xl font-bold mb-2">{{ $result->ime_prezime }}</h4>
                                    <p class="text-gray-600 mb-2">{{ $result->adresa }}</p>
                                    @if($result->telefon)
                                        <p class="text-gray-600 mb-3">📞 {{ $result->telefon }}</p>
                                    @endif
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $result->uplate->count() }} uplata</span>
                                    
                                @elseif($result instanceof \App\Models\Preminuli)
                                    <h4 class="text-xl font-bold mb-2">{{ $result->ime_prezime }}</h4>
                                    @if($result->datum_rodjenja)
                                        <p class="text-sm text-gray-600">Rođen: {{ $result->datum_rodjenja->format('d.m.Y') }}</p>
                                    @endif
                                    @if($result->datum_smrti)
                                        <p class="text-sm text-gray-600 mb-2">Preminuo: {{ $result->datum_smrti->format('d.m.Y') }}</p>
                                    @endif
                                    @if($result->grobnoMesto)
                                        <p class="text-gray-600 mb-3">
                                            🏛️ {{ $result->grobnoMesto->sifra }} ({{ $result->grobnoMesto->oznaka }})
                                        </p>
                                    @endif
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $result->uplate->count() }} uplata</span>
                                    
                                @elseif($result instanceof \App\Models\Uplata)
                                    <h4 class="text-xl font-bold mb-2">Uplata za period: {{ $result->period }}</h4>
                                    <p class="text-gray-700 mb-1"><strong>Iznos:</strong> {{ number_format($result->iznos, 2) }} RSD</p>
                                    <p class="text-gray-700 mb-2"><strong>Datum uplate:</strong> {{ $result->datum_uplate->format('d.m.Y') }}</p>
                                    @if($result->uplatilac)
                                        <p class="text-gray-600 mb-1">
                                            👥 {{ $result->uplatilac->ime_prezime }}
                                        </p>
                                    @endif
                                    @if($result->preminuli)
                                        <p class="text-gray-600 mb-1">
                                            👤 {{ $result->preminuli->ime_prezime }}
                                        </p>
                                    @endif
                                    @if($result->grobnoMesto)
                                        <p class="text-gray-600 mb-3">
                                            🏛️ {{ $result->grobnoMesto->sifra }} ({{ $result->grobnoMesto->oznaka }})
                                        </p>
                                    @endif
                                    <span class="text-xs font-medium px-2.5 py-0.5 rounded {{ $result->uplaceno ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $result->uplaceno ? 'Uplaćeno' : 'Neuplaćeno' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Nema rezultata</h3>
                    <p class="text-gray-500 mb-6">Pokušajte sa drugim pojmom za pretragu.</p>
                    <a href="{{ route('search.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        🔍 Nova pretraga
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 