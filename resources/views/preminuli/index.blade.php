<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Preminuli
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($preminuli->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ime</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prezime</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Datum rođenja</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Datum smrti</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Grobno mesto</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($preminuli as $p)
                                        <tr>
                                            <td class="px-4 py-2">{{ $p->ime }}</td>
                                            <td class="px-4 py-2">{{ $p->prezime }}</td>
                                            <td class="px-4 py-2">{{ $p->datum_rodjenja ? $p->datum_rodjenja->format('d.m.Y') : '-' }}</td>
                                            <td class="px-4 py-2">{{ $p->datum_smrti ? $p->datum_smrti->format('d.m.Y') : '-' }}</td>
                                            <td class="px-4 py-2">{{ $p->grobnoMesto->sifra ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $preminuli->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-4xl mb-4 text-gray-400">Preminuli</div>
                            <h3 class="text-2xl font-bold text-gray-700 mb-2">Nema preminulih</h3>
                            <p class="text-gray-500 mb-6">Još uvek nije unet nijedan preminuli.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 