<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\MainController;
use App\Http\Controllers\Web\SepetController;

Route::get('/main', [MainController::class, 'main'])->name('main');
Route::get('/sepet', [SepetController::class, 'sepet'])->name('sepet');
