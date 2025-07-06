<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Statistika
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-100 border border-blue-200 rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $statistika['ukupno_uplata'] }}</div>
                    <div class="text-blue-800">Ukupno uplata</div>
                </div>
                <div class="bg-green-100 border border-green-200 rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">{{ number_format($statistika['ukupan_iznos'], 2) }} RSD</div>
                    <div class="text-green-800">Ukupan iznos uplata</div>
                </div>
                <div class="bg-yellow-100 border border-yellow-200 rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-yellow-600 mb-2">{{ $statistika['uplaceno'] }}</div>
                    <div class="text-yellow-800">Uplaćeno</div>
                </div>
                <div class="bg-red-100 border border-red-200 rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-red-600 mb-2">{{ $statistika['neuplaceno'] }}</div>
                    <div class="text-red-800">Neuplaćeno</div>
                </div>
                <div class="bg-gray-100 border border-gray-200 rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-gray-700 mb-2">{{ $statistika['ukupno_grobnih_mesta'] }}</div>
                    <div class="text-gray-800">Grobnih mesta</div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-green-700 mb-2">{{ $statistika['ukupno_uplatilaca'] }}</div>
                    <div class="text-green-800">Uplatilaca</div>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-gray-700 mb-2">{{ $statistika['ukupno_preminulih'] }}</div>
                    <div class="text-gray-800">Preminulih</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 