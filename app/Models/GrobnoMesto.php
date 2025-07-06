<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GrobnoMesto extends Model
{
    protected $fillable = [
        'sifra',
        'oznaka',
        'lokacija',
        'uplatilac_id',
        'napomena',
    ];

    public function preminuli(): HasMany
    {
        return $this->hasMany(Preminuli::class);
    }

    public function uplate(): HasMany
    {
        return $this->hasMany(Uplata::class);
    }

    public function uplatilac(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Uplatilac::class);
    }
}
