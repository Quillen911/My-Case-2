<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\MainController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\AuthController;
 
Route::get('/login', [AuthController::class, 'login'])->name('login');                                                           
Route::post('/postlogin', [AuthController::class,'postlogin'])->name('postlogin');



Route::middleware(['auth'])->group(function(){
    Route::get('/main', [MainController::class, 'main'])->name('main');
    
    Route::prefix('cart')->group(function(){
        Route::get('/', [CartController::class, 'cart'])->name('cart');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::delete('/{id}', [CartController::class, 'delete'])->name('delete');
    });
    
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
});    

