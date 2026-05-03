<?php
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {


    // Atualizar status
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create');

    // Atualizar status
    Route::patch('{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Cancelar pedido
    Route::patch('{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Adicionar produto ao pedido
    Route::post('add-product', [OrderController::class, 'addProduct'])->name('orders.addProduct');
});
?>
