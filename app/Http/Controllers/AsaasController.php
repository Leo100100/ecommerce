<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AsaasController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'billingType' => 'required|in:PIX,BOLETO',
        ]);

        $user = auth()->user();

        $order = Order::where('user_id', $user->id)
            ->where('status', 'pendente')
            ->with('items.product')
            ->first();

        if (!$order || $order->items->isEmpty()) {
            return back()->with('error', 'Carrinho vazio.');
        }

        $apiUrl = env('ASAAS_API_URL');
        $apiKey = env('ASAAS_API_KEY');

        // =========================
        // CRIAR CLIENTE NO ASAAS
        // =========================

        $customerResponse = Http::withHeaders([
    'access_token' => $apiKey,
    'Content-Type' => 'application/json',
        ])->post($apiUrl . '/customers', [
    'name' => $user->name ?? 'Cliente Teste',
    'email' => $user->email ?? 'teste@teste.com',
    'cpfCnpj' => '12345678909',
    // 'phone' => '71999999999',
    ]);

        if (!$customerResponse->successful()) {
            return back()->with('error', 'Erro ao criar cliente no ASAAS.');
        //     dd(
        // $customerResponse->status(),
        // $customerResponse->json(),
        // $customerResponse->body()
    // );
        }

        $customerId = $customerResponse->json('id');

        // =========================
        // CRIAR COBRANÇA
        // =========================

        $paymentResponse = Http::withHeaders([
            'access_token' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post($apiUrl . '/payments', [
            'customer' => $customerId,
            'billingType' => $request->billingType,
            'value' => number_format($order->total, 2, '.', ''),
            'dueDate' => now()->addDay()->format('Y-m-d'),
            'description' => 'Pedido #' . $order->id,
            'externalReference' => (string) $order->id,
        ]);

        if (!$paymentResponse->successful()) {
            return back()->with('error', 'Erro ao gerar pagamento.');
        }

        $payment = $paymentResponse->json();

$order->update([
    'asaas_payment_id' => $payment['id'] ?? null,
    'asaas_invoice_url' => $payment['invoiceUrl'] ?? null,
    'asaas_bank_slip_url' => $payment['bankSlipUrl'] ?? null,
    'status' => 'aguardando_pagamento',
]);
        return view('checkout.asaas', [
            'payment' => $payment,
            'billingType' => $request->billingType,
        ]);
    }
}
