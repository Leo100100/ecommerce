@extends('layouts.app')

@section('title', 'Carrinho')

@push('styles')
<style>
    .cart-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        border-bottom: 1px solid #ddd;
    }
    .cart-item:last-child { border-bottom: none; }

    .cart-thumb {
        width: 70px;
        height: 70px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 1.6rem;
        flex-shrink: 0;
        border: 1px solid #ddd;
    }

    .cart-item-info { flex: 1; min-width: 0; }
    .cart-item-name {
        font-weight: 600;
        font-size: .9rem;
        color: #333;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cart-item-unit { font-size: .78rem; color: #888; }

    .qty-control {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        overflow: hidden;
        flex-shrink: 0;
    }
    .qty-btn {
        background: #f5f5f5;
        border: none;
        width: 30px;
        height: 30px;
        cursor: pointer;
        font-size: .9rem;
        font-weight: bold;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    .qty-val {
        width: 34px;
        text-align: center;
        font-size: .875rem;
        font-weight: 600;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        line-height: 30px;
    }

    .cart-subtotal {
        font-size: .95rem;
        font-weight: bold;
        color: #333;
        min-width: 90px;
        text-align: right;
        flex-shrink: 0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: .875rem;
        padding: 6px 0;
        color: #333;
    }
    .summary-row.total {
        font-size: 1.1rem;
        font-weight: bold;
        padding-top: 10px;
        margin-top: 4px;
        border-top: 2px solid #ddd;
    }
    .summary-row .label { color: #666; }
    .summary-row.total .label { color: #333; }

    .empty-cart {
        text-align: center;
        padding: 60px 24px;
    }
    .empty-cart h5 {
        font-weight: bold;
        margin-bottom: 8px;
    }
    .empty-cart p {
        color: #666;
        font-size: .875rem;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')

<div style="font-size:.8rem;color:#666;margin-bottom:8px;">
    <a href="{{ route('search.index') }}" style="color:#0066cc;text-decoration:none;">Produtos</a>
    &rsaquo; Carrinho
</div>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="ec-page-title">
        Meu Carrinho
        @if($order && $order->items->isNotEmpty())
            <span style="font-size:.85rem;font-weight:normal;color:#888;margin-left:8px;">
                ({{ $order->items->sum('quantidade') }} {{ $order->items->sum('quantidade') == 1 ? 'item' : 'itens' }})
            </span>
        @endif
    </h1>
    <a href="{{ route('search.index') }}" class="btn-ec-ghost">
        <i class="bi bi-arrow-left"></i> Continuar comprando
    </a>
</div>

@if(!$order || $order->items->isEmpty())

    <div class="ec-card">
        <div class="empty-cart">
            <i class="bi bi-cart-x" style="font-size:3.5rem;color:#ccc;display:block;margin-bottom:14px;"></i>
            <h5>Seu carrinho está vazio</h5>
            <p>Adicione produtos para continuar comprando.</p>
            <a href="{{ route('search.index') }}" class="btn-ec-primary">
                <i class="bi bi-bag-plus"></i> Ver produtos
            </a>
        </div>
    </div>

@else

    <div class="row g-4 align-items-start">

        {{-- ITENS --}}
        <div class="col-lg-8">
            <div class="ec-card">

                <div style="padding:14px 20px;border-bottom:1px solid #ddd;display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-size:.85rem;font-weight:bold;">Produtos</span>
                    <form action="{{ route('cart.clear') }}" method="POST"
                          onsubmit="return confirm('Limpar todo o carrinho?')">
                        @csrf
                        <button type="submit" style="background:none;border:none;font-size:.78rem;color:#cc0000;cursor:pointer;padding:0;">
                            <i class="bi bi-trash3"></i> Limpar carrinho
                        </button>
                    </form>
                </div>

                @foreach($order->items as $item)
                <div class="cart-item">

                    <div class="cart-thumb">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div class="cart-item-info">
                        <div class="cart-item-name">{{ $item->product->nome }}</div>
                        <div class="cart-item-unit">
                            Unitário: <strong>R$ {{ number_format($item->preco, 2, ',', '.') }}</strong>
                        </div>

                        <form action="{{ route('cart.destroy', $item->product_id) }}" method="POST"
                              class="d-inline mt-1"
                              onsubmit="return confirm('Remover «{{ $item->product->nome }}» do carrinho?')">
                            @csrf
                            <button type="submit" style="background:none;border:none;font-size:.75rem;color:#cc0000;cursor:pointer;padding:0;">
                                <i class="bi bi-x-circle"></i> Remover
                            </button>
                        </form>
                    </div>

                    <div class="d-flex flex-column align-items-center gap-1">
                        <div class="qty-control">
                            <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="qty-btn" title="Diminuir">−</button>
                            </form>
                            <span class="qty-val">{{ $item->quantidade }}</span>
                            <form action="{{ route('cart.update', $item->product_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantidade" value="{{ $item->quantidade + 1 }}">
                                <button type="submit" class="qty-btn" title="Aumentar">+</button>
                            </form>
                        </div>
                        <span style="font-size:.7rem;color:#888;">qtd.</span>
                    </div>

                    <div class="cart-subtotal">
                        R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}
                    </div>

                </div>
                @endforeach

            </div>
        </div>

        {{-- RESUMO --}}
        <div class="col-lg-4">
            <div class="ec-card p-4">

                <h6 style="font-weight:bold;margin-bottom:16px;">Resumo do Pedido</h6>

                @php
                    $subtotal = $order->items->sum(fn($i) => $i->preco * $i->quantidade);
                    $frete    = 0;
                @endphp

                <div class="summary-row">
                    <span class="label">Subtotal</span>
                    <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                </div>

                <div class="summary-row">
                    <span class="label">Frete</span>
                    <span style="color:#067D62;font-weight:600;">
                        {{ $frete == 0 ? 'Grátis' : 'R$ '.number_format($frete, 2, ',', '.') }}
                    </span>
                </div>

                <div class="summary-row total">
                    <span class="label">Total</span>
                    <span>R$ {{ number_format($subtotal + $frete, 2, ',', '.') }}</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn-ec-primary w-100 justify-content-center mt-4" style="width:100%;padding:10px 20px;display:flex;">
                    <i class="bi bi-lock-fill"></i> Finalizar compra
                </a>
                

                <a href="{{ route('search.index') }}" class="btn-ec-ghost w-100 justify-content-center mt-2" style="width:100%;">
                    <i class="bi bi-arrow-left"></i> Continuar comprando
                </a>

            </div>
        </div>

    </div>

@endif

@endsection
