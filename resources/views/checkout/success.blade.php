@extends('layouts.app')
@section('title', 'Pedido Confirmado')

@section('content')

<div style="max-width:500px; margin:40px auto; background:#fff; border:1px solid #ddd; padding:32px; text-align:center;">

    <i class="bi bi-check-circle-fill" style="font-size:3rem; color:#067D62; display:block; margin-bottom:16px;"></i>

    <h2 style="font-size:1.3rem; font-weight:bold; margin-bottom:8px;">Pedido confirmado!</h2>
    <p style="color:#666; margin-bottom:4px;">Pedido <strong>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
    <p style="color:#666; margin-bottom:24px;">Total: <strong>R$ {{ number_format($order->total, 2, ',', '.') }}</strong></p>

    <div style="display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">
        <a href="{{ route('orders.index') }}" class="btn-ec-primary">
            <i class="bi bi-receipt"></i> Ver meus pedidos
        </a>
        <a href="{{ route('products.index') }}" class="btn-ec-ghost">
            <i class="bi bi-bag-plus"></i> Continuar comprando
        </a>
    </div>

</div>

@endsection
