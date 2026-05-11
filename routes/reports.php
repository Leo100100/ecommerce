<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;


// imprimir pedido
Route::get('/orders/{id}/print', [OrderController::class, 'print'])
    ->name('orders.print');

// relatório de vendas
Route::get('/reports/orders', [ReportsController::class, 'orders'])
    ->name('reports.orders');
