<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
    Route::get('/produtos/{product}', [ProductController::class, 'show'])->name('products.show');

    // CRUD completo de pedidos
    Route::resource('pedidos', OrderController::class)->names('orders');

    // Atualizar status
    Route::patch('/pedidos/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');

    // Cancelar pedido
    Route::patch('/pedidos/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('orders.cancel');

    Route::post('/orders/add-product', [OrderController::class, 'addProduct'])
    ->name('orders.addProduct');

     Route::get('/carrinho', [OrderController::class, 'cart'])
    ->name('cart.index');

});
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');

    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('orders.cancel');


    Route::resource('products', ProductController::class);
    // TODO (candidato): rotas de criação/atualização de pedidos
    // Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');
    // Route::patch('/pedidos/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');



require __DIR__.'/auth.php';


