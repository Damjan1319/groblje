<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Uplatioci
            </h2>
            @auth
                @if(auth()->user()->canAdd())
                    <a href="{{ route('uplatilac.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Dodaj uplatioca
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($uplatilaci->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ime i prezime</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adresa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Za koga</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uplate</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($uplatilaci as $uplatilac)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">{{ $uplatilac->ime_prezime }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $uplatilac->adresa }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $uplatilac->telefon ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @if($uplatilac->imePreminulog || $uplatilac->prezimePreminulog)
                                                        {{ $uplatilac->imePreminulog }} {{ $uplatilac->prezimePreminulog }}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $uplatilac->uplate->count() }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('uplatilac.show', $uplatilac) }}" 
                                                       class="text-blue-600 hover:text-blue-900">Pregled</a>
                                                    @auth
                                                        @if(auth()->user()->canEdit())
                                                            <a href="{{ route('uplatilac.edit', $uplatilac) }}" 
                                                               class="text-yellow-600 hover:text-yellow-900">Izmeni</a>
                                                        @endif
                                                        @if(auth()->user()->canDelete())
                                                            <form action="{{ route('uplatilac.destroy', $uplatilac) }}" 
                                                                  method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                                        onclick="return confirm('Da li ste sigurni da želite da obrišete ovog uplatioca?')">
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
                            {{ $uplatilaci->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-4xl mb-4 text-gray-400">Uplatioci</div>
                            <h3 class="text-2xl font-bold text-gray-700 mb-2">Nema uplatioca</h3>
                            <p class="text-gray-500 mb-6">Još uvek nije kreiran nijedan uplatilac.</p>
                            @auth
                                @if(auth()->user()->canAdd())
                                    <a href="{{ route('uplatilac.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Dodaj prvog uplatioca
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 