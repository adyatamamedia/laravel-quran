<?php

use Adyatama\Quran\Controllers\HomeController;
use Adyatama\Quran\Controllers\SurahController;
use Adyatama\Quran\Controllers\VerseController;
use Adyatama\Quran\Controllers\SearchController;
use Adyatama\Quran\Controllers\TahlilController;
use Adyatama\Quran\Controllers\WiridController;
use Adyatama\Quran\Controllers\MaulidController;
use Illuminate\Support\Facades\Route;

Route::name('quran.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/tahlil-yasin', [TahlilController::class, 'index'])->name('tahlil');
    Route::get('/wirid-doa/{slug?}', [WiridController::class, 'index'])->name('wirid');
    Route::get('/maulid', [MaulidController::class, 'index'])->name('maulid');
    Route::get('/{surahSlug}', [SurahController::class, 'show'])->name('surah.show');
    Route::get('/{surahSlug}/{ayah}', [VerseController::class, 'show'])->name('verse.show');
});
