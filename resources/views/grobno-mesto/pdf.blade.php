<h2>Izveštaj o grobnom mestu</h2>
<hr>
<h3>Osnovni podaci</h3>
<ul>
    <li><strong>Šifra:</strong> {{ $grobnoMesto->sifra }}</li>
    <li><strong>Oznaka:</strong> {{ $grobnoMesto->oznaka }}</li>
    <li><strong>Lokacija:</strong> {{ $grobnoMesto->lokacija ?? 'Nije uneto' }}</li>
    <li><strong>Uplatilac:</strong> 
        @if($grobnoMesto->uplatilacs->count())
            @foreach($grobnoMesto->uplatilacs as $u)
                {{ $u->ime_prezime }}@if(!$loop->last), @endif
            @endforeach
        @else
            Nije dodeljen
        @endif
    </li>
    <li><strong>Napomena:</strong> {{ $grobnoMesto->napomena ?? 'Nema napomene' }}</li>
</ul>

<h3>Preminuli</h3>
@if($grobnoMesto->uplatilacs->count() && $grobnoMesto->uplatilacs->first()->imePreminulog)
    <div style="margin-bottom: 8px; font-weight: bold;">
        @foreach($grobnoMesto->uplatilacs as $u)
            {{ $u->imePreminulog }} {{ $u->prezimePreminulog }}@if(!$loop->last), @endif
        @endforeach
    </div>
@else
    <div style="margin-bottom: 8px; color: #888;">Nema preminulog.</div>
@endif

<h3>Uplate</h3>
@if($grobnoMesto->uplate->count() > 0)
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Uplatilac</th>
                <th>Preminuli</th>
                <th>Period</th>
                <th>Iznos</th>
                <th>Datum</th>
                <th>Napomena</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grobnoMesto->uplate as $uplata)
                <tr>
                    <td>
                        @if($grobnoMesto->uplatilacs->count())
                            @foreach($grobnoMesto->uplatilacs as $u)
                                {{ $u->imePreminulog }} {{ $u->prezimePreminulog }}@if(!$loop->last), @endif
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $uplata->preminuli->ime_prezime ?? $uplata->za_koga ?? '-' }}</td>
                    <td>{{ $uplata->period }}</td>
                    <td>{{ number_format($uplata->iznos, 2) }} RSD</td>
                    <td>{{ $uplata->datum_uplate ? $uplata->datum_uplate->format('d.m.Y') : 'N/A' }}</td>
                    <td>
                        @if($uplata->grobnoMesto && $uplata->grobnoMesto->uplatilacs->count())
                            @foreach($uplata->grobnoMesto->uplatilacs as $u)
                                {{ $u->imePreminulog }} {{ $u->prezimePreminulog }}@if(!$loop->last), @endif
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Nema uplata za ovo grobno mesto.</p>
@endif 