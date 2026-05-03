<?php
use App\Http\Controllers\ProductController;

Route::prefix('orders')->group(function () {

    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');

    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::post('/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
});

?>

