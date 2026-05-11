<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        
        // $stats = [
        //     'total_products' => Product::count(),
        //     'total_orders'   => Order::count(),
        //      'orders_pending' => Order::where('status', 'pendente')->count(),
        //  ];

        $products = Product::latest()->take(9)->get();
        return view('home', compact('products'));
    }

}
