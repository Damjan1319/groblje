@extends('layouts.app')
@section('content')
<style>
@media print {
    body { background: #fff !important; }
    .no-print, nav, header, .navigation, .navbar, .print-hide {
        display: none !important;
    }
    .print-container { max-width: 100% !important; padding: 0 !important; }
    table { font-size: 12px !important; }
    h2, h3 { font-size: 18px !important; margin-bottom: 8px !important; }
    .print-gap { margin-bottom: 8px !important; }
    .print-p-2 { padding: 4px !important; }
    .print-p-4 { padding: 8px !important; }
    .print-mb-2 { margin-bottom: 8px !important; }
    .print-mb-4 { margin-bottom: 16px !important; }
}
</style>
<div class="max-w-5xl mx-auto py-8 print-container">
    <button onclick="window.print()" class="no-print mb-4 bg-gray-700 hover:bg-gray-900 text-white px-4 py-2 rounded shadow float-right">Štampaj</button>
    <h2 class="text-3xl font-bold mb-8 text-center">Napredna statistika uplata</h2>
    <form method="GET" class="mb-8 flex flex-wrap gap-6 items-end justify-center bg-white p-6 rounded shadow no-print">
        <div>
            <label for="godine" class="block text-sm font-medium text-gray-700 mb-1">Godine za poređenje</label>
            <select name="godine[]" id="godine" multiple class="form-select mt-1 block w-44 border-gray-300 rounded">
                @foreach($godine as $g)
                    <option value="{{ $g }}" {{ in_array($g, (array)$izabraneGodine) ? 'selected' : '' }}>{{ $g }}</option>
                @endforeach
            </select>
            <div class="text-xs text-gray-500 mt-1">Drži Ctrl/⌘ za više godina</div>
        </div>
        <div>
            <label for="meseci" class="block text-sm font-medium text-gray-700 mb-1">Meseci za poređenje</label>
            <select name="meseci[]" id="meseci" multiple class="form-select mt-1 block w-44 border-gray-300 rounded">
                @foreach($meseci as $broj => $naziv)
                    <option value="{{ $broj }}" {{ in_array($broj, (array)$izabraniMeseci) ? 'selected' : '' }}>{{ $naziv }}</option>
                @endforeach
            </select>
            <div class="text-xs text-gray-500 mt-1">Drži Ctrl/⌘ za više meseci</div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow">Prikaži</button>
    </form>

    <div class="mb-8 bg-white p-6 rounded shadow print-p-4 print-mb-4">
        <h3 class="text-xl font-semibold mb-4 print-mb-2">Pregled po izabranim periodima</h3>
        @if(count($statistika) === 0)
            <div class="text-center text-gray-400 py-8">Nema podataka za izabrane filtere.</div>
        @else
        <table class="min-w-full divide-y divide-gray-200 mb-4 print-gap">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Broj uplata</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ukupan iznos (RSD)</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($statistika as $s)
                    <tr>
                        <td class="px-4 py-2 font-semibold">{{ $meseci[$s['mesec']] ?? '' }} {{ $s['godina'] }}</td>
                        <td class="px-4 py-2">{{ $s['broj'] }}</td>
                        <td class="px-4 py-2">{{ number_format($s['suma'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex flex-col gap-y-2 mt-4 print-gap">
            <div>
                <div class="text-sm text-gray-500">Ukupno uplata</div>
                <div class="text-2xl font-bold text-blue-700">{{ array_sum(array_column($statistika, 'broj')) }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Ukupan iznos</div>
                <div class="text-2xl font-bold text-green-700">{{ number_format(array_sum(array_column($statistika, 'suma')), 2) }} RSD</div>
            </div>
        </div>
        @endif
    </div>

    <div class="bg-white p-6 rounded shadow print-p-4 print-mb-4">
        <h3 class="text-xl font-semibold mb-4 print-mb-2">Grafik poređenja</h3>
        <canvas id="statistikaChart" height="100"></canvas>
    </div>

    @php
        $komentar = '';
        $periodiTekst = '';
        if (count($statistika) === 0) {
            $komentar = 'Nema podataka za izabrane filtere.';
        } else {
            $periodiTekst = collect($statistika)->map(function($s) use ($meseci) {
                return trim(($meseci[$s['mesec']] ?? '') . ' ' . $s['godina']);
            })->implode(', ');
            if (count($statistika) === 1) {
                $s = reset($statistika);
                $naziv = ($meseci[$s['mesec']] ?? '') . ' ' . $s['godina'];
                $komentar = "Za period $naziv ima ukupno {$s['broj']} uplata u iznosu od " . number_format($s['suma'], 2) . " RSD.";
            } else {
                $najvise = collect($statistika)->sortByDesc('broj')->first();
                $najmanje = collect($statistika)->sortBy('broj')->first();
                $ukupno = array_sum(array_column($statistika, 'broj'));
                $ukupnoIznos = array_sum(array_column($statistika, 'suma'));
                $prosek = round($ukupno / count($statistika), 2);
                $prosekIznos = round($ukupnoIznos / count($statistika), 2);
                $komentar = "Za izabrane periode: $periodiTekst. Ukupno uplata: $ukupno, ukupno iznos: " . number_format($ukupnoIznos, 2) . " RSD. Prosečno po periodu: $prosek uplata, " . number_format($prosekIznos, 2) . " RSD. ";
                $komentar .= "Najviše uplata ima u periodu " . ($meseci[$najvise['mesec']] ?? '') . " {$najvise['godina']} ({$najvise['broj']} uplata), a najmanje u periodu " . ($meseci[$najmanje['mesec']] ?? '') . " {$najmanje['godina']} ({$najmanje['broj']} uplata).";
            }
        }
    @endphp
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 text-blue-800 rounded print-p-2 print-mb-2">
        <strong>Analiza:</strong> {{ $komentar ?? 'Nema podataka za izabrane filtere.' }}
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statistikaChart').getContext('2d');
    const data = {
        labels: [
            @foreach($statistika as $s)
                '{{ $meseci[$s['mesec']] ?? '' }} {{ $s['godina'] }}',
            @endforeach
        ],
        datasets: [
            {
                label: 'Broj uplata',
                data: [@foreach($statistika as $s) {{ $s['broj'] }}, @endforeach],
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2
            },
            {
                label: 'Ukupan iznos (RSD)',
                data: [@foreach($statistika as $s) {{ $s['suma'] }}, @endforeach],
                backgroundColor: 'rgba(16, 185, 129, 0.3)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 2,
                type: 'line',
                yAxisID: 'y1',
            }
        ]
    };
    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'top' },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Broj uplata' }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: { display: true, text: 'Ukupan iznos (RSD)' },
                    grid: { drawOnChartArea: false }
                }
            }
        }
    };
    new Chart(ctx, config);
</script>
@endsection 