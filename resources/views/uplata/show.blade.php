<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalji uplate
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('uplata.index') }}" class="text-blue-600 hover:underline">&larr; Nazad na sve uplate</a>
                    </div>
                    <table class="table-auto w-full mb-6">
                        <tbody>
                            <tr>
                                <td class="font-bold pr-4 py-2">Šifra uplate:</td>
                                <td>{{ $uplata->id }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-4 py-2">Grobno mesto:</td>
                                <td>{{ $uplata->grobnoMesto->sifra ?? '-' }} ({{ $uplata->grobnoMesto->oznaka ?? '' }})</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-4 py-2">Uplatilac:</td>
                                <td>{{ $uplata->uplatilac->ime_prezime ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-4 py-2">Za koga:</td>
                                <td>{{ $uplata->za_koga }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-4 py-2">Iznos:</td>
                                <td>{{ number_format($uplata->iznos, 2) }} RSD</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-4 py-2">Plaćeno:</td>
                                <td>{{ $uplata->uplaceno ? 'Da' : 'Ne' }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-4 py-2">Period:</td>
                                <td>{{ $uplata->period }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-4 py-2">Datum uplate:</td>
                                <td>{{ $uplata->datum_uplate ? $uplata->datum_uplate->format('d.m.Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-4 py-2">Napomena:</td>
                                <td>{{ $uplata->napomena ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold pr-4 py-2">Preminuli:</td>
                                <td>{{ $uplata->preminuli->ime_prezime ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{ route('uplata.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Nazad</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 