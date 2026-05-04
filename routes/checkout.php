<?php


use App\Http\Controllers\CheckoutController;

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');




?>
