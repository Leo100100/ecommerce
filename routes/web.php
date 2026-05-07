<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WebhookController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    require __DIR__.'/orders.php';
    require __DIR__.'/products.php';
    require __DIR__.'/cart.php';
    require __DIR__.'/checkout.php';
    require __DIR__.'/reports.php';

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});


require __DIR__.'/webhook.php';

require __DIR__.'/auth.php';

