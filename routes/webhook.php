<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;


Route::post('/asaas/webhook', [WebhookController::class, 'handle'])
    ->withoutMiddleware([VerifyCsrfToken::class]);
