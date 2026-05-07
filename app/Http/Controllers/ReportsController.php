<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;



class ReportsController extends Controller
{
   public function orders(Request $request)
{
    $query = Order::with('user')
        ->where('status', 'pago');

    // FILTRO POR DATA
    if ($request->filled('data_inicio') && $request->filled('data_fim')) {
        $query->whereBetween('created_at', [
            $request->data_inicio . ' 00:00:00',
            $request->data_fim . ' 23:59:59'
        ]);
    }

    $orders = $query->orderBy('created_at', 'desc')->get();

    $total = $orders->sum('total');

    $pdf = Pdf::loadView('reports.orders', compact('orders', 'total'));

    return $pdf->stream('relatorio-vendas.pdf');
}
}
