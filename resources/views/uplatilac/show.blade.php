<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👥 Detalji uplatioca
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('uplatilac.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Nazad
                </a>
                @auth
                    @if(auth()->user()->canEdit())
                        <a href="{{ route('uplatilac.edit', $uplatilac) }}" 
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
                                    <span class="font-medium text-gray-700">Ime i prezime uplatioca:</span>
                                    <span class="ml-2 text-gray-900">{{ $uplatilac->ime_prezime }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Adresa:</span>
                                    <span class="ml-2 text-gray-900">{{ $uplatilac->adresa }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Telefon:</span>
                                    <span class="ml-2 text-gray-900">{{ $uplatilac->telefon ?? 'Nije uneto' }}</span>
                                </div>
                                @if($uplatilac->imePreminulog || $uplatilac->prezimePreminulog)
                                <div>
                                    <span class="font-medium text-gray-700">Za koga uplaćuje:</span>
                                    <span class="ml-2 text-gray-900">{{ $uplatilac->imePreminulog }} {{ $uplatilac->prezimePreminulog }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">💰 Uplate</h3>
                            @if($uplatilac->uplate->count() > 0)
                                <div class="space-y-2">
                                    @foreach($uplatilac->uplate as $uplata)
                                        <div class="border border-gray-200 rounded p-3">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <div class="font-medium text-gray-900">
                                                        {{ $uplata->grobnoMesto->oznaka ?? 'N/A' }} - {{ $uplata->period }}
                                                    </div>
                                                    <div class="text-sm text-gray-600">
                                                        {{ $uplata->preminuli->ime_prezime ?? 'N/A' }}
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="font-bold text-green-600">
                                                        {{ number_format($uplata->iznos, 2) }} RSD
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $uplata->datum_uplate ? $uplata->datum_uplate->format('d.m.Y') : 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">Nema uplata za ovog uplatioca.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm text-gray-500">Ukupno uplata:</span>
                                <span class="ml-2 font-bold text-lg text-green-600">
                                    {{ number_format($uplatilac->uplate->sum('iznos'), 2) }} RSD
                                </span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Broj uplata:</span>
                                <span class="ml-2 font-bold text-lg text-blue-600">
                                    {{ $uplatilac->uplate->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 