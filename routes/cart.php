<?php
use App\Http\Controllers\CartController;

Route::prefix('cart')->group(function () {

    Route::get('/', [CartController::class, 'index'])->name('cart.index');
});

?>



