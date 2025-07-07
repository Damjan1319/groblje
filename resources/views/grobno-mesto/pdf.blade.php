<h2>Izveštaj o grobnom mestu</h2>
<hr>
<h3>Osnovni podaci</h3>
<ul>
    <li><strong>Šifra:</strong> {{ $grobnoMesto->sifra }}</li>
    <li><strong>Oznaka:</strong> {{ $grobnoMesto->oznaka }}</li>
    <li><strong>Lokacija:</strong> {{ $grobnoMesto->lokacija ?? 'Nije uneto' }}</li>
    <li><strong>Uplatilac:</strong> {{ $grobnoMesto->uplatilac->ime_prezime ?? 'Nije dodeljen' }}</li>
    <li><strong>Napomena:</strong> {{ $grobnoMesto->napomena ?? 'Nema napomene' }}</li>
</ul>

<h3>Preminuli</h3>
@if($grobnoMesto->preminuli->count() > 0)
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Ime i prezime</th>
                <th>Datum rođenja</th>
                <th>Datum smrti</th>
                <th>Za koga (iz uplate)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grobnoMesto->preminuli as $preminuli)
                <tr>
                    <td>{{ $preminuli->ime_prezime }}</td>
                    <td>{{ $preminuli->datum_rodjenja ? $preminuli->datum_rodjenja->format('d.m.Y') : 'N/A' }}</td>
                    <td>{{ $preminuli->datum_smrti ? $preminuli->datum_smrti->format('d.m.Y') : 'N/A' }}</td>
                    @php
                        $uplataZaKoga = $grobnoMesto->uplate->where('za_koga', $preminuli->ime_prezime)->sortByDesc('datum_uplate')->first();
                    @endphp
                    <td>{{ $uplataZaKoga ? $uplataZaKoga->za_koga : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Nema preminulih na ovom grobnom mestu.</p>
@endif

<h3>Uplate</h3>
@if($grobnoMesto->uplate->count() > 0)
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Uplatilac</th>
                <th>Za koga</th>
                <th>Period</th>
                <th>Iznos</th>
                <th>Datum</th>
                <th>Napomena</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grobnoMesto->uplate as $uplata)
                <tr>
                    <td>{{ $uplata->uplatilac->ime_prezime ?? 'N/A' }}</td>
                    <td>{{ $uplata->za_koga }}</td>
                    <td>{{ $uplata->period }}</td>
                    <td>{{ number_format($uplata->iznos, 2) }} RSD</td>
                    <td>{{ $uplata->datum_uplate ? $uplata->datum_uplate->format('d.m.Y') : 'N/A' }}</td>
                    <td>{{ $uplata->napomena ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Nema uplata za ovo grobno mesto.</p>
@endif 