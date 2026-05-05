<?php

use App\Http\Controllers\WebhookController;

Route::post('/asaas/webhook', [WebhookController::class, 'handle']);
