<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use App\Services\OrderService;
use App\Enums\OrderStatus;

class WebhookController extends Controller
{



public function handle(Request $request, OrderService $orderService)
{
    // VALIDAÇÃO DE SEGURANÇA
    $signature = $request->header('asaas-signature');
    $payload = $request->getContent();
    $secret = config('services.asaas.webhook_secret');

    $expectedSignature = hash_hmac('sha256', $payload, $secret);

    if (!hash_equals($expectedSignature, $signature)) {
        Log::warning('Webhook inválido - assinatura incorreta');
        return response()->json(['error' => 'Invalid signature'], 403);
    }

    Log::info('Webhook Asaas recebido', $request->all());

    $event = $request->input('event');
    $paymentId = $request->input('payment.id');

    if (!$paymentId) {
        Log::warning('Webhook sem payment.id');
        return response()->json(['error' => 'payment.id não encontrado'], 400);
    }

    $order = Order::where('asaas_payment_id', $paymentId)->first();

    if (!$order) {
        Log::warning('Pedido não encontrado para payment_id: ' . $paymentId);
        return response()->json(['error' => 'Pedido não encontrado'], 404);
    }

    try {

        switch ($event) {

            case 'PAYMENT_RECEIVED':
            case 'PAYMENT_CONFIRMED':

                $orderService->updateStatus(
                    $order,
                    OrderStatus::PAGO,
                    'Pagamento confirmado via webhook Asaas'
                );

                break;

            case 'PAYMENT_OVERDUE':

                $orderService->updateStatus(
                    $order,
                    OrderStatus::VENCIDO,
                    'Pagamento vencido'
                );

                break;

            case 'PAYMENT_DELETED':
            case 'PAYMENT_CANCELED':

                $orderService->updateStatus(
                    $order,
                    OrderStatus::CANCELADO,
                    'Pagamento cancelado'
                );

                break;

            default:
                Log::info('Evento não tratado: ' . $event);
                break;
        }

    } catch (\Exception $e) {

        Log::error('Erro ao atualizar pedido', [
            'error' => $e->getMessage()
        ]);

        return response()->json(['error' => 'Erro interno'], 500);
    }


    return response()->json(['success' => true]);
}
}
