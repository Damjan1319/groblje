<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Dodaj novo grobno mesto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('grobno-mesto.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="sifra" class="block text-sm font-medium text-gray-700 mb-2">Šifra *</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sifra') border-red-500 @enderror" 
                                       id="sifra" name="sifra" value="{{ old('sifra') }}" 
                                       placeholder="npr. 0001" required>
                                @error('sifra')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="oznaka" class="block text-sm font-medium text-gray-700 mb-2">Oznaka *</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('oznaka') border-red-500 @enderror" 
                                       id="oznaka" name="oznaka" value="{{ old('oznaka') }}" 
                                       placeholder="npr. gm01" required>
                                @error('oznaka')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label for="lokacija" class="block text-sm font-medium text-gray-700 mb-2">Lokacija</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('lokacija') border-red-500 @enderror" 
                                   id="lokacija" name="lokacija" value="{{ old('lokacija') }}" 
                                   placeholder="Opis lokacije">
                            @error('lokacija')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mt-6">
                            <label for="napomena" class="block text-sm font-medium text-gray-700 mb-2">Napomena</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('napomena') border-red-500 @enderror" 
                                      id="napomena" name="napomena" rows="3" 
                                      placeholder="Dodatne napomene">{{ old('napomena') }}</textarea>
                            @error('napomena')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-between mt-6">
                            <a href="{{ route('grobno-mesto.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                ← Nazad
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                💾 Sačuvaj
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 