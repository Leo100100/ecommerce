<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\AsaasService;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function store(AsaasService $asaas)
{
    $order = Order::where('user_id', auth()->id())
        ->where('status', 'pendente')
        ->with('items.product')
        ->first();

    if (!$order || $order->items->isEmpty()) {
        return back()->with('error', 'Carrinho vazio');
    }

    //  CRIAR CLIENTE
    $customer = $asaas->createCustomer([
    'name' => auth()->user()->name,
    'email' => auth()->user()->email,
    'cpfCnpj' => '12345678909',
    ]);

    if (!isset($customer['id'])) {
    return back()->with('error', 'Erro ao criar cliente: ' . ($customer['errors'][0]['description'] ?? 'Erro desconhecido'));
    }

    //CRIAR PAGAMENTO
    $payment = $asaas->createPayment([
        'customer' => $customer['id'],
        'billingType' => 'PIX',
        'value' => $order->total,
        'dueDate' => now()->addDays(1)->format('Y-m-d'),
        'description' => "Pedido #{$order->id}",
    ]);


    if (!isset($payment['id'])) {
        return back()->with('error', 'Erro ao gerar pagamento');
    }
    // if (!isset($payment['id'])) {
    // dd($payment);
// }

    // ATUALIZA PEDIDO
    $order->update([
    'status' => 'pendente'
    ]);
    return redirect($payment['invoiceUrl']);
    }
}
