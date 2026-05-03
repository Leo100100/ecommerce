<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

Route::patch('/orders', [OrderController::class, 'index'])->name('orders.index');

    require __DIR__.'/orders.php';
    require __DIR__.'/products.php';

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});

require __DIR__.'/auth.php';


