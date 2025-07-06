<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GrobnoMestoController;
use App\Http\Controllers\UplatilacController;
use App\Http\Controllers\PreminuliController;
use App\Http\Controllers\UplataController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatistikaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('search.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('search.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute za pretragu (dostupne svim korisnicima)
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::post('/search', [SearchController::class, 'search'])->name('search.search');

// Rute za grobna mesta
Route::resource('grobno-mesto', GrobnoMestoController::class)->middleware('auth');

// Rute za uplatioce
Route::resource('uplatilac', UplatilacController::class)->middleware('auth');

// Rute za preminule
Route::resource('preminuli', PreminuliController::class)->middleware('auth');

// Rute za uplate
Route::resource('uplata', UplataController::class)->middleware('auth');
Route::get('/grobno-mesto/{grobnoMesto}/uplata/create', [UplataController::class, 'createForGrobnoMesto'])->name('grobno-mesto.uplata.create');
Route::post('/grobno-mesto/{grobnoMesto}/uplata', [UplataController::class, 'storeForGrobnoMesto'])->name('grobno-mesto.uplata.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/statistika', [StatistikaController::class, 'index'])->middleware('auth')->name('statistika.index');

require __DIR__.'/auth.php';
