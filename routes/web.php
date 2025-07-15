<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\MainController;
use App\Http\Controllers\Web\BagController;
use App\Http\Controllers\Web\AuthController;
 
Route::get('/login', [AuthController::class, 'login'])->name('login');                                                           
Route::post('/postlogin', [AuthController::class,'postlogin'])->name('postlogin');



Route::middleware(['auth'])->group(function(){
    Route::get('/main', [MainController::class, 'main'])->name('main');
    
    Route::prefix('bag')->group(function(){
        Route::get('/', [BagController::class, 'bag'])->name('bag');
        Route::post('/add', [BagController::class, 'add'])->name('add');
        Route::delete('/{id}', [BagController::class, 'delete'])->name('delete');
    });
    
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
});    

