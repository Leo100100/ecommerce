<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{


    public function index()
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pendente')
            ->with('items.product')
            ->first();

        return view('cart.index', compact('order'));
    }
    public function add($id)
    {
        $product = Product::findOrFail($id);


        $order = Order::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'status' => 'pendente'
            ]
        );

        $item = $order->items()->where('product_id', $id)->first();

        if ($item) {
            $item->increment('quantidade');
        }  else {
            $order->items()->create([
                'product_id' => $id,
                'quantidade' => 1,
                'preco' => $product->preco
            ]);

            $order->recalcularTotal();
        }


            return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
        }

    public function remove($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pendente')
            ->first();

        if ($order) {
            $item = $order->items()->where('product_id', $id)->first();
            if ($item) {
                if ($item->quantidade > 1) {
                    $item->decrement('quantidade');
                } else {
                    $item->delete();
                }
            }
            $order->recalcularTotal();
        }

        return redirect()->back()->with('success', 'Produto removido do carrinho!');
    }
    public function update(Request $request, $id)
{
    $order = Order::where('user_id', auth()->id())
        ->where('status', 'pendente')
        ->first();

    if ($order) {
        $item = $order->items()->where('product_id', $id)->first();

        if ($item) {
            $novaQtd = max(1, (int)$request->quantidade);
            $item->update(['quantidade' => $novaQtd]);
        }

        // RECARREGA OS ITEMS ATUALIZADOS
        $order->load('items');

        // RECALCULA
        $total = $order->items->sum(function ($item) {
            return $item->preco * $item->quantidade;
        });

        $order->update(['total' => $total]);
    }

    return redirect()->back();
}

}
