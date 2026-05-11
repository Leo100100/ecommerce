<?php

use App\Http\Controllers\ProductController;

Route::prefix('products')->group(function () {

    // Seller-only management routes
    Route::middleware(['auth', 'vendedor'])->group(function () {
        Route::get('/',              [ProductController::class, 'index'])->name('products.index');
        Route::get('/create',        [ProductController::class, 'create'])->name('products.create');
        Route::post('/',             [ProductController::class, 'store'])->name('products.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/{product}',      [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{product}',   [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Public product detail (buyers and guests can view)
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');

});
