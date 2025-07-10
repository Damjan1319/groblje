<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Panel - Import Podataka') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Import podataka iz seedera</h3>
                    
                    <div class="mb-4">
                        <p class="text-gray-600 mb-4">
                            Ova opcija će pokrenuti sve seedere u pravom redosledu:
                        </p>
                        <ul class="list-disc list-inside text-gray-600 mb-4">
                            <li>Grobna mesta</li>
                            <li>Uplatioci</li>
                            <li>Veze između uplatioca i grobnih mesta</li>
                            <li>Uplate</li>
                        </ul>
                    </div>

                    <button id="importBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Pokreni Import
                    </button>

                    <div id="importStatus" class="mt-4 hidden">
                        <div class="bg-gray-100 p-4 rounded">
                            <p id="statusMessage" class="text-gray-700"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('importBtn').addEventListener('click', function() {
            const btn = this;
            const statusDiv = document.getElementById('importStatus');
            const statusMessage = document.getElementById('statusMessage');
            
            btn.disabled = true;
            btn.textContent = 'Import u toku...';
            statusDiv.classList.remove('hidden');
            statusMessage.textContent = 'Pokretanje import-a...';
            
            fetch('/admin/import-data', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusMessage.textContent = data.message;
                    statusDiv.classList.remove('bg-gray-100');
                    statusDiv.classList.add('bg-green-100');
                } else {
                    statusMessage.textContent = data.message;
                    statusDiv.classList.remove('bg-gray-100');
                    statusDiv.classList.add('bg-red-100');
                }
            })
            .catch(error => {
                statusMessage.textContent = 'Greška prilikom import-a: ' + error.message;
                statusDiv.classList.remove('bg-gray-100');
                statusDiv.classList.add('bg-red-100');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Pokreni Import';
            });
        });
    </script>
</x-app-layout> 