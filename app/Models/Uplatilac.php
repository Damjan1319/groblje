<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Uplatilac extends Model
{
    protected $fillable = [
        'sifra',
        'ime',
        'prezime',
        'ime_prezime',
        'adresa',
        'telefon',
        'imePreminulog',
        'prezimePreminulog',
    ];

    public function uplate(): HasMany
    {
        return $this->hasMany(Uplata::class);
    }

    public function grobnaMesta()
    {
        return $this->belongsToMany(\App\Models\GrobnoMesto::class, 'grobno_mesto_uplatilac');
    }
}
