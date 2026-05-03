<?php
use App\Http\Controllers\ProductController;

Route::prefix('products')->group(function () {

    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');

    Route::post('/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/destroy', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
});

?>

