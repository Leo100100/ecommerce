<?php
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {

    Route::get('/', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/show', [OrderController::class, 'show'])->name('orders.show');
    // Atualizar status
    Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
    // Adicionar produto ao pedido
    Route::post('add-product', [OrderController::class, 'addProduct'])->name('orders.addProduct');

    Route::delete('/destroy', [OrderController::class, 'destroy'])->name('orders.destroy');
    // Atualizar status
    Route::patch('{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    // Cancelar pedido
    Route::patch('{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});
?>
