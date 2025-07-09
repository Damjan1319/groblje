<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Uplata extends Model
{
    protected $fillable = [
        'grobno_mesto_id',
        'uplatilac_id',
        'za_koga',
        'iznos',
        'datum_uplate',
        'period',
        'uplaceno',
        'napomena',
    ];

    protected $casts = [
        'datum_uplate' => 'date',
        'uplaceno' => 'boolean',
        'iznos' => 'decimal:2',
    ];

    public function grobnoMesto(): BelongsTo
    {
        return $this->belongsTo(GrobnoMesto::class);
    }

    public function uplatilac(): BelongsTo
    {
        return $this->belongsTo(Uplatilac::class);
    }

    public function preminuli(): BelongsTo
    {
        return $this->belongsTo(Preminuli::class);
    }

    // Uklanjamo relaciju sa preminuli jer sada koristimo tekstualno polje 'za_koga'
}
