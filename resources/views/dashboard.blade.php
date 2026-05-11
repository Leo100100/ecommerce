@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #ccc;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .stat-icon {
        font-size: 1.5rem;
        color: #555;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 2px;
    }

    .stat-value {
        font-size: 1.4rem;
        font-weight: bold;
        color: #111;
    }

    .stat-sub {
        font-size: 0.75rem;
        color: #888;
    }

    .welcome-banner {
        background: #232F3E;
        padding: 20px 24px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .welcome-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #fff;
        margin-bottom: 4px;
    }

    .welcome-sub {
        font-size: 0.85rem;
        color: #aaa;
        margin: 0;
    }

    .welcome-badge {
        background: #0066cc;
        color: #fff;
        padding: 6px 14px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .section-title {
        font-size: 1rem;
        font-weight: bold;
        margin: 0;
    }

    .section-link {
        font-size: 0.85rem;
        color: #0066cc;
        text-decoration: none;
    }

    .section-link:hover { text-decoration: underline; }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #ddd;
        display: flex;
        flex-direction: column;
    }

    .product-img {
        background: #f3f4f6;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 2rem;
    }

    .product-body {
        padding: 12px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .product-name {
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .product-desc {
        font-size: 0.78rem;
        color: #666;
        margin-bottom: 8px;
    }

    .product-price {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .product-stock {
        font-size: 0.75rem;
        color: #067D62;
        margin-bottom: 10px;
    }

    .product-stock.low { color: #B45309; }

    .product-actions {
        margin-top: auto;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .btn-add-cart {
        background: #0066cc;
        color: #fff;
        border: none;
        padding: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        width: 100%;
    }

    .btn-view-product {
        background: #fff;
        color: #0066cc;
        border: 1px solid #ccc;
        padding: 7px;
        font-size: 0.8rem;
        cursor: pointer;
        width: 100%;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .empty-state {
        background: #fff;
        border: 1px solid #ddd;
        padding: 40px 20px;
        text-align: center;
        color: #666;
    }
</style>
@endpush

@section('content')

<div class="welcome-banner">
    <div>
        <div class="welcome-title">Bem-vindo de volta, {{ Auth::user()->name }}!</div>
        <p class="welcome-sub">Gerencie produtos, pedidos e muito mais pelo painel.</p>
    </div>
    <span class="welcome-badge">
        <i class="bi bi-shield-check"></i> Admin
    </span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
        <div>
            <div class="stat-label">Produtos</div>
            <div class="stat-value">{{ $products->count() }}</div>
            <div class="stat-sub">cadastrados</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-receipt"></i></div>
        <div>
            <div class="stat-label">Pedidos</div>
            <div class="stat-value">—</div>
            <div class="stat-sub">total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-currency-dollar"></i></div>
        <div>
            <div class="stat-label">Receita</div>
            <div class="stat-value">—</div>
            <div class="stat-sub">este mês</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-people"></i></div>
        <div>
            <div class="stat-label">Clientes</div>
            <div class="stat-value">—</div>
            <div class="stat-sub">ativos</div>
        </div>
    </div>
</div>

<div class="section-header">
    <h2 class="section-title">Produtos em destaque</h2>
    <a href="{{ route('products.index') }}" class="section-link">Ver todos</a>
</div>

@if($products->isEmpty())
    <div class="empty-state">
        <i class="bi bi-box-seam" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
        <p>Nenhum produto cadastrado ainda.</p>
        <a href="{{ route('products.create') }}" class="btn-ec-primary mt-3" style="display:inline-flex;">
            <i class="bi bi-plus-lg"></i> Cadastrar produto
        </a>
    </div>
@else
    <div class="product-grid">
        @foreach($products as $index => $product)
            @php
                $name  = $product->nome ?? $product->name ?? 'Produto';
                $price = $product->preco ?? $product->price ?? 0;
                $desc  = $product->descricao ?? '';
                $stock = $product->estoque ?? null;
                $icons = ['bi-laptop', 'bi-phone', 'bi-headphones', 'bi-tv', 'bi-controller', 'bi-watch', 'bi-camera', 'bi-speaker'];
                $icon  = $icons[$index % count($icons)];
            @endphp
            <div class="product-card">
                <div class="product-img">
                    <i class="bi {{ $icon }}"></i>
                </div>

                <div class="product-body">
                    <div class="product-name">{{ $name }}</div>

                    @if($desc)
                        <div class="product-desc">{{ $desc }}</div>
                    @endif

                    <div class="product-price">R$ {{ number_format($price, 2, ',', '.') }}</div>

                    @if($stock !== null)
                        <div class="product-stock {{ $stock < 5 ? 'low' : '' }}">
                            {{ $stock < 5 ? "Apenas $stock restantes!" : 'Em estoque' }}
                        </div>
                    @else
                        <div class="product-stock">Em estoque</div>
                    @endif

                    <div class="product-actions">
                        <form action="{{ route('orders.addProduct') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button class="btn-add-cart" type="submit">Adicionar ao carrinho</button>
                        </form>

                        <a href="{{ route('products.show', $product) }}" class="btn-view-product">Ver detalhes</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
