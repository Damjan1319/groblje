<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GrobnoMesto extends Model
{
    protected $fillable = [
        'sifra',
        'oznaka',
        'lokacija',
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

    public function uplatilacs(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Uplatilac::class, 'grobno_mesto_uplatilac');
    }
}
