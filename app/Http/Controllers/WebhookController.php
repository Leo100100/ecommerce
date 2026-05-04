<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        
        Log::info('Webhook Asaas recebido', $request->all());

        // Evento enviado pelo Asaas
        $event = $request->input('event');

        // ID do pagamento no Asaas
        $paymentId = $request->input('payment.id');

        if (!$paymentId) {
            Log::warning('Webhook sem payment.id');
            return response()->json(['error' => 'payment.id não encontrado'], 400);
        }

        // Busca pedido no banco
        $order = Order::where('asaas_payment_id', $paymentId)->first();

        if (!$order) {
            Log::warning('Pedido não encontrado para payment_id: ' . $paymentId);
            return response()->json(['error' => 'Pedido não encontrado'], 404);
        }

        // Trata eventos do Asaas
        switch ($event) {

            case 'PAYMENT_RECEIVED':
            case 'PAYMENT_CONFIRMED':
                $order->update([
                    'status' => 'pago'
                ]);
                break;

            case 'PAYMENT_OVERDUE':
                $order->update([
                    'status' => 'vencido'
                ]);
                break;

            case 'PAYMENT_DELETED':
            case 'PAYMENT_CANCELED':
                $order->update([
                    'status' => 'cancelado'
                ]);
                break;

            default:
                Log::info('Evento não tratado: ' . $event);
                break;
        }

        return response()->json(['success' => true]);
    }
}
