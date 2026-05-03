<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'statusHistory', 'user');

        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $users = \App\Models\User::all(); // ou só o usuário logado, depende da regra

        return view('orders.create', compact('users'));
    }
    public function store(Request $request)
    {
        try {
            $order = \App\Models\Order::create([
                'user_id' => auth()->id(),
                'total' => $request->total,
                'status' => $request->status,
            ]);



        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        \App\Models\Order::create([
        'user_id' => auth()->user()->id,
        'total' => $request->total,
        'status' => $request->status,
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Pedido criado com sucesso!');
    }
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Status atualizado com sucesso!');
    }
    public function cancel(Order $order)
    {
        $order->update([
            'status' => 'cancelado',
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Pedido cancelado!');
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

    // 1. pega ou cria carrinho do usuário
        $order = Order::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'status' => 'pendente'
            ],
            [
                'total' => 0
            ]
        );

    // 2. verifica se produto já existe no carrinho
        $item = OrderItem::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            // incrementa quantidade
            $item->increment('quantidade');
        } else {
            // cria item novo
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantidade' => 1,
                'preco' => $product->preco ?? $product->price,
            ]);
        }
    // 3. recalcula total
        $order->update([
            'total' => $order->items->sum(fn ($i) => $i->quantidade * $i->preco),
        ]);

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }
    public function cart()
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pendente')
            ->with('items.product')
            ->first();

        return view('cart.index', compact('order'));
    }

}

    // TODO (candidato): implementar store, update status, cancelamento

