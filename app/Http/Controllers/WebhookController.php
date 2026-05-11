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
        /**
         * =========================================================
         * VALIDAÇÃO DE ASSINATURA
         * =========================================================
         */

        $signature = $request->header('asaas-signature');
        $secret = config('services.asaas.webhook_secret');

        // Sandbox do ASAAS às vezes não envia assinatura
        if ($secret && $signature) {

            $payload = $request->getContent();

            $expectedSignature = hash_hmac(
                'sha256',
                $payload,
                $secret
            );

            if (!hash_equals($expectedSignature, $signature)) {

                Log::warning('Webhook inválido - assinatura incorreta');

                return response()->json([
                    'error' => 'Invalid signature'
                ], 403);
            }
        }

        /**
         * =========================================================
         * LOG DO WEBHOOK
         * =========================================================
         */

        Log::info('Webhook Asaas recebido', [
            'payload' => $request->all()
        ]);

        /**
         * =========================================================
         * DADOS DO EVENTO
         * =========================================================
         */

        $event = $request->input('event');
        $paymentId = $request->input('payment.id');

        if (!$paymentId) {

            Log::warning('Webhook sem payment.id');

            return response()->json([
                'error' => 'payment.id não encontrado'
            ], 400);
        }

        /**
         * =========================================================
         * BUSCA PEDIDO
         * =========================================================
         */

        $order = Order::where('asaas_payment_id', $paymentId)
            ->latest()
            ->first();

        if (!$order) {

            Log::warning('Pedido não encontrado', [
                'payment_id' => $paymentId
            ]);

            return response()->json([
                'error' => 'Pedido não encontrado'
            ], 404);
        }

        /**
         * =========================================================
         * EVITA DUPLICIDADE
         * =========================================================
         */

        if ($order->status === OrderStatus::PAGO) {

            Log::info('Pedido já pago', [
                'order_id' => $order->id
            ]);

            return response()->json([
                'success' => true
            ]);
        }

        /**
         * =========================================================
         * PROCESSAMENTO DOS EVENTOS
         * =========================================================
         */

        try {

            switch ($event) {

                /**
                 * PAGAMENTO CONFIRMADO
                 */
                case 'PAYMENT_RECEIVED':
                case 'PAYMENT_CONFIRMED':

                    $orderService->updateStatus(
                        $order,
                        OrderStatus::PAGO,
                        'Pagamento confirmado via webhook Asaas'
                    );

                    Log::info('Pedido marcado como PAGO', [
                        'order_id' => $order->id
                    ]);

                    break;

                /**
                 * PAGAMENTO VENCIDO
                 */
                case 'PAYMENT_OVERDUE':

                    $orderService->updateStatus(
                        $order,
                        OrderStatus::VENCIDO,
                        'Pagamento vencido'
                    );

                    Log::info('Pedido marcado como VENCIDO', [
                        'order_id' => $order->id
                    ]);

                    break;

                /**
                 * PAGAMENTO CANCELADO
                 */
                case 'PAYMENT_DELETED':
                case 'PAYMENT_CANCELED':

                    $orderService->updateStatus(
                        $order,
                        OrderStatus::CANCELADO,
                        'Pagamento cancelado'
                    );

                    Log::info('Pedido marcado como CANCELADO', [
                        'order_id' => $order->id
                    ]);

                    break;

                /**
                 * EVENTOS NÃO TRATADOS
                 */
                default:

                    Log::info('Evento não tratado', [
                        'event' => $event
                    ]);

                    break;
            }

        } catch (\Exception $e) {

            Log::error('Erro ao atualizar pedido', [
                'error' => $e->getMessage(),
                'order_id' => $order->id ?? null
            ]);

            return response()->json([
                'error' => 'Erro interno'
            ], 500);
        }

        /**
         * =========================================================
         * SUCESSO
         * =========================================================
         */

        return response()->json([
            'success' => true
        ]);
    }
}
