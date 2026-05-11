<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{


    public function data()
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pendente')
            ->with('items.product')
            ->first();

        if (!$order) {
            return response()->json(['items' => [], 'total' => 0, 'count' => 0]);
        }

        $items = $order->items->map(fn($i) => [
            'id'         => $i->product_id,
            'nome'       => $i->product?->nome ?? 'Produto removido',
            'preco'      => $i->preco,
            'quantidade' => $i->quantidade,
            'subtotal'   => $i->preco * $i->quantidade,
        ]);

        return response()->json([
            'items' => $items,
            'total' => $order->total,
            'count' => $order->items->sum('quantidade'),
        ]);
    }

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

        $order = Order::firstOrCreate([
            'user_id' => auth()->id(),
            'status'  => 'pendente',
        ]);

        $item = $order->items()->where('product_id', $id)->first();

        if ($item) {
            $item->increment('quantidade');
        } else {
            $order->items()->create([
                'product_id' => $id,
                'quantidade' => 1,
                'preco'      => $product->preco,
            ]);
        }

        $order->recalcularTotal();

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

        if (request()->expectsJson()) {
            return $this->jsonCart($order);
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
            $order->recalcularTotal();
        }

        if (request()->expectsJson()) {
            return $this->jsonCart($order);
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pendente')
            ->first();

        if ($order) {
            $order->items()->where('product_id', $id)->delete();
            $order->recalcularTotal();
        }

        if (request()->expectsJson()) {
            return $this->jsonCart($order);
        }

        return redirect()->back()->with('success', 'Produto removido do carrinho!');
    }

    private function jsonCart($order)
    {
        if (!$order) {
            return response()->json(['items' => [], 'total' => 0, 'count' => 0]);
        }

        $order->load('items.product');

        $items = $order->items->map(fn($i) => [
            'id'         => $i->product_id,
            'nome'       => $i->product?->nome ?? 'Produto removido',
            'preco'      => $i->preco,
            'quantidade' => $i->quantidade,
            'subtotal'   => $i->preco * $i->quantidade,
        ]);

        return response()->json([
            'items' => $items,
            'total' => $order->total,
            'count' => $order->items->sum('quantidade'),
        ]);
    }

    public function clear()
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pendente')
            ->first();

        if ($order) {
            $order->items()->delete();
            $order->update(['total' => 0]);
        }

        return redirect()->back()->with('success', 'Carrinho limpo!');
    }

}
