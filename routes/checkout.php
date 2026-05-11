<?php


use App\Http\Controllers\CheckoutController;

Route::get('/checkout',                 [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout',                [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/sucesso/{order}', [CheckoutController::class, 'success'])->name('checkout.success');