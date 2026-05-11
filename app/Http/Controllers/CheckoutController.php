<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatusHistory;

class CheckoutController extends Controller
{
    public function index()
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pendente')
            ->with('items.product')
            ->first();

        if (!$order || $order->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        $addresses      = auth()->user()->addresses()->orderByDesc('principal')->get();
        $paymentMethods = auth()->user()->paymentMethods()->orderByDesc('principal')->get();

        $freteGratis = rand(1, 100) <= 30;

        $deliveryOptions = [
            ['label' => 'Padrão (5 a 7 dias úteis)',  'days' => 7,  'pct' => 0.08],
            ['label' => 'Expresso (2 a 3 dias úteis)', 'days' => 3,  'pct' => 0.15],
            ['label' => 'Agendado (10 dias úteis)',    'days' => 10, 'pct' => 0.05],
        ];

        $deliveryOptions = array_map(function ($opt) use ($freteGratis, $order) {
            $valorBase      = round($order->total * $opt['pct'], 2);
            $opt['frete']   = ($freteGratis && $opt['days'] === 7) ? 0 : $valorBase;
            return $opt;
        }, $deliveryOptions);

        return view('checkout.index', compact('order', 'addresses', 'paymentMethods', 'deliveryOptions', 'freteGratis'));
    }

    public function store(Request $request)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pendente')
            ->with('items.product')
            ->first();

        if (!$order || $order->items->isEmpty()) {
            return back()->with('error', 'Carrinho vazio.');
        }

        $request->validate([
            'endereco'          => 'required|string',
            'dias_entrega'      => 'required|integer|min:1',
            'frete_valor'       => 'required|numeric|min:0',
            'cartao_nome'       => 'required|string|max:100',
            'cartao_numero'     => 'required|string|min:16|max:19',
            'cartao_validade'   => 'required|string',
            'cartao_cvv'        => 'required|string|min:3|max:4',
        ]);

        $dataEntrega   = now()->addWeekdays((int) $request->dias_entrega)->toDateString();
        $freteValor    = (float) $request->frete_valor;
        $totalFinal    = $order->total + $freteValor;
        $ultimos       = substr(str_replace(' ', '', $request->cartao_numero), -4);

        $order->update([
            'status'                    => 'confirmado',
            'total'                     => $totalFinal,
            'endereco_entrega'          => $request->endereco,
            'data_entrega_prevista'     => $dataEntrega,
            'pagamento_titular'         => strtoupper($request->cartao_nome),
            'pagamento_bandeira'        => $request->cartao_bandeira ?? 'outro',
            'pagamento_ultimos_digitos' => $ultimos,
            'pagamento_validade'        => $request->cartao_validade,
            'frete_valor'               => $freteValor,
        ]);

        OrderStatusHistory::create([
            'order_id'  => $order->id,
            'status'    => 'confirmado',
            'descricao' => 'Pedido confirmado',
        ]);

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}
