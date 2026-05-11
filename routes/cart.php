<?php
use App\Http\Controllers\CartController;


Route::prefix('cart')->group(function () {

    Route::get('/',       [CartController::class, 'index'])->name('cart.index');
    Route::get('/data',   [CartController::class, 'data'])->name('cart.data');
    Route::post('/add/{id}',     [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{id}',  [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove/{id}',  [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/clear',        [CartController::class, 'clear'])->name('cart.clear');

});