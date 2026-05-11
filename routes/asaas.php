<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsaasController;

Route::post('/checkout/asaas', [AsaasController::class, 'checkout'])
    ->name('checkout.asaas');
