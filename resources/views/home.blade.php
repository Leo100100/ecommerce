@extends('layouts.app')
@section('title', 'Página inicial')

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
        text-decoration: none;
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
        color: #007185;
        text-decoration: none;
    }

    .section-link:hover {
        text-decoration: underline;
    }

    /* CARROSSEL */
    .carousel {
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        border: 1px solid #ddd;
    }

    .carousel-track {
        display: flex;
        width: 300%;
        transition: transform 0.5s ease;
    }

    .carousel-slide {
        width: 33.333%;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 10px;
        color: #fff;
        text-align: center;
        padding: 20px;
    }

    .carousel-slide-title {
        font-size: 1.3rem;
        font-weight: bold;
    }

    .carousel-slide-sub {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.35);
        color: #fff;
        border: none;
        padding: 10px 14px;
        font-size: 1.1rem;
        cursor: pointer;
    }

    .carousel-btn-prev { left: 0; }
    .carousel-btn-next { right: 0; }

    .carousel-dots {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 6px;
    }

    .carousel-dot {
        width: 8px;
        height: 8px;
        background: rgba(255,255,255,0.5);
        border: none;
        cursor: pointer;
        padding: 0;
    }

    .carousel-dot.active {
        background: #fff;
    }

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

    .product-stock.low {
        color: #B45309;
    }

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

{{-- WELCOME BANNER --}}
<div class="welcome-banner">
    <div>
        @auth
            <div class="welcome-title">Bem-vindo de volta, {{ Auth::user()->name }}!</div>
            <p class="welcome-sub">Acompanhe seus pedidos e explore nossos produtos.</p>
        @else
            <div class="welcome-title">Bem-vindo à CompreJá!</div>
            <p class="welcome-sub">Explore nossos produtos e <a href="{{ route('register') }}" style="color:#66aaff;">crie sua conta</a> para comprar.</p>
        @endauth
    </div>
    @auth
        <a href="{{ route('profile.index') }}" class="welcome-badge">
            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
        </a>
    @else
        <a href="{{ route('login') }}" class="welcome-badge">
            <i class="bi bi-box-arrow-in-right"></i> Entrar
        </a>
    @endauth
</div>

{{-- STATS (vendedor) ou CARROSSEL (comprador/visitante) --}}
@auth
    @if(Auth::user()->vendedor)
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
    @else
    @include('home._carousel')
    @endif
@else
@include('home._carousel')
@endauth

{{-- PRODUCTS SECTION --}}
<div class="section-header">
    <h2 class="section-title">Produtos em destaque</h2>
    @auth
        <a href="{{ Auth::user()->vendedor ? route('products.index') : route('search.index') }}" class="section-link">Ver todos</a>
    @else
        <a href="{{ route('search.index') }}" class="section-link">Ver todos</a>
    @endauth
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
