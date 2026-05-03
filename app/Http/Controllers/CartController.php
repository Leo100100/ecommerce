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

}
