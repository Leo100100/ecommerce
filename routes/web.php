<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// ─── PÚBLICA — sem autenticação ──────────────────────────────
Route::get('/', fn () => redirect()->route('home'));

Route::get('/home', [DashboardController::class, 'index'])->name('home');

require __DIR__.'/products.php';   // index + show são públicos; CRUD exige auth internamente
require __DIR__.'/search.php';     // busca é pública

// ─── PROTEGIDA — exige login ──────────────────────────────────
Route::middleware(['auth'])->group(function () {

    require __DIR__.'/cart.php';
    require __DIR__.'/checkout.php';
    require __DIR__.'/orders.php';
    require __DIR__.'/reports.php';
    require __DIR__.'/asaas.php';

    // Perfil
    Route::get('/perfil',                                [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/perfil/dados',                         [ProfileController::class, 'updateDados'])->name('profile.dados');
    Route::post('/perfil/senha',                         [ProfileController::class, 'updateSenha'])->name('profile.senha');
    Route::post('/perfil/enderecos',                     [ProfileController::class, 'storeEndereco'])->name('profile.enderecos.store');
    Route::delete('/perfil/enderecos/{address}',         [ProfileController::class, 'destroyEndereco'])->name('profile.enderecos.destroy');
    Route::post('/perfil/enderecos/{address}/principal', [ProfileController::class, 'setPrincipal'])->name('profile.enderecos.principal');

    // Cartões
    Route::post('/perfil/cartoes',                               [ProfileController::class, 'storeCartao'])->name('profile.cartoes.store');
    Route::delete('/perfil/cartoes/{paymentMethod}',             [ProfileController::class, 'destroyCartao'])->name('profile.cartoes.destroy');
    Route::post('/perfil/cartoes/{paymentMethod}/principal',     [ProfileController::class, 'setPrincipalCartao'])->name('profile.cartoes.principal');

});

require __DIR__.'/webhook.php';
require __DIR__.'/auth.php';
