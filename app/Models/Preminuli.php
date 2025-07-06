<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Preminuli extends Model
{
    protected $fillable = [
        'ime_prezime',
        'datum_rodjenja',
        'datum_smrti',
        'grobno_mesto_id',
    ];

    protected $casts = [
        'datum_rodjenja' => 'date',
        'datum_smrti' => 'date',
    ];

    public function grobnoMesto(): BelongsTo
    {
        return $this->belongsTo(GrobnoMesto::class);
    }

    public function uplate(): HasMany
    {
        return $this->hasMany(Uplata::class);
    }
}
