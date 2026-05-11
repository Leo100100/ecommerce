@extends('layouts.app')
@section('title', $product->nome)

@push('styles')
<style>
    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 20px;
    }
    .breadcrumb-nav a { color: #0066cc; text-decoration: none; }
    .breadcrumb-nav a:hover { text-decoration: underline; }

    .product-detail-grid {
        display: grid;
        grid-template-columns: 300px 1fr 260px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .product-detail-grid { grid-template-columns: 1fr; }
    }

    .product-image-panel {
        background: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .product-main-image {
        width: 100%;
        aspect-ratio: 1;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ccc;
        font-size: 5rem;
    }

    .product-info-panel {
        background: #fff;
        border: 1px solid #ddd;
        padding: 24px;
    }
    .product-info-title { font-size: 1.2rem; font-weight: bold; color: #333; margin-bottom: 16px; }
    .divider { border: none; border-top: 1px solid #ddd; margin: 14px 0; }

    .price-section { margin-bottom: 16px; }
    .price-label   { font-size: 0.78rem; color: #666; margin-bottom: 2px; }
    .price-big     { font-size: 1.8rem; font-weight: bold; color: #111; }

    .detail-table { width: 100%; font-size: 0.875rem; }
    .detail-table tr td { padding: 7px 0; vertical-align: top; }
    .detail-table tr td:first-child { color: #666; width: 120px; padding-right: 12px; }
    .detail-table tr td:last-child  { color: #333; font-weight: 600; }
    .stock-low { color: #B45309; }
    .stock-ok  { color: #067D62; }

    .buy-box {
        background: #fff;
        border: 1px solid #ddd;
        padding: 20px;
    }
    .buy-price-big { font-size: 1.5rem; font-weight: bold; color: #111; margin-bottom: 8px; }
    .buy-stock-ok  { color: #067D62; font-weight: 600; font-size: 0.9rem; margin: 10px 0; }
    .buy-stock-low { color: #B45309; font-weight: 600; font-size: 0.9rem; margin: 10px 0; }
    .buy-box label { font-size: 0.8rem; color: #666; font-weight: 600; }
    .buy-qty {
        width: 80px;
        border: 1px solid #ccc;
        padding: 6px 10px;
        font-size: 0.875rem;
        margin-bottom: 12px;
        outline: none;
    }
    .buy-qty:focus { border-color: #0066cc; }
    .btn-add-cart-big {
        width: 100%;
        background: #0066cc;
        color: #fff;
        border: none;
        padding: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .admin-actions {
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #ddd;
        display: flex;
        gap: 8px;
        flex-direction: column;
    }
</style>
@endpush

@section('content')

{{-- BREADCRUMB --}}
<div class="breadcrumb-nav">
    <a href="{{ route('home') }}">Início</a>
    <i class="bi bi-chevron-right"></i>
    <a href="{{ route('products.index') }}">Produtos</a>
    <i class="bi bi-chevron-right"></i>
    <span>{{ $product->nome }}</span>
</div>

@php
    $price = $product->preco ?? 0;
    $stock = $product->estoque ?? null;
@endphp

<div class="product-detail-grid">

    {{-- IMAGE PANEL --}}
    <div class="product-image-panel">
        <div class="product-main-image">
            <i class="bi bi-box-seam"></i>
        </div>
        @if($product->ativo)
            <span class="ec-badge ec-badge-success">Produto ativo</span>
        @else
            <span class="ec-badge ec-badge-muted">Produto inativo</span>
        @endif
    </div>

    {{-- INFO PANEL --}}
    <div class="product-info-panel">
        <div class="product-info-title">{{ $product->nome }}</div>

        <hr class="divider">

        <div class="price-section">
            <div class="price-label">Preço</div>
            <div class="price-big">R$ {{ number_format($price, 2, ',', '.') }}</div>
        </div>

        <hr class="divider">

        @if($product->descricao)
            <p style="font-size:.875rem; color:#666; line-height:1.6; margin-bottom:14px;">
                {{ $product->descricao }}
            </p>
            <hr class="divider">
        @endif

        <table class="detail-table">
            <tr>
                <td>ID do produto</td>
                <td>#{{ $product->id }}</td>
            </tr>
            @if($stock !== null)
            <tr>
                <td>Estoque</td>
                <td class="{{ $stock < 5 ? 'stock-low' : 'stock-ok' }}">
                    {{ $stock }} unidades
                </td>
            </tr>
            @endif
            <tr>
                <td>Status</td>
                <td>
                    @if($product->ativo)
                        <span class="ec-badge ec-badge-success">Ativo</span>
                    @else
                        <span class="ec-badge ec-badge-muted">Inativo</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- BUY BOX --}}
    <div class="buy-box">
        <div class="buy-price-big">R$ {{ number_format($price, 2, ',', '.') }}</div>

        @if($stock !== null && $stock < 5)
            <div class="buy-stock-low">
                <i class="bi bi-exclamation-triangle-fill"></i> Apenas {{ $stock }} restantes!
            </div>
        @else
            <div class="buy-stock-ok">
                <i class="bi bi-check-circle-fill"></i> Em estoque
            </div>
        @endif

        <label for="qty">Quantidade</label><br>
        <input type="number" class="buy-qty" id="qty" value="1" min="1">

        <form action="{{ route('orders.addProduct') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button class="btn-add-cart-big" type="submit">
                <i class="bi bi-cart-plus"></i> Adicionar ao carrinho
            </button>
        </form>

        <div class="admin-actions">
            <a href="{{ route('products.edit', $product) }}" class="btn-ec-outline">
                <i class="bi bi-pencil"></i> Editar produto
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST"
                  onsubmit="return confirm('Excluir «{{ $product->nome }}»?')">
                @csrf
                @method('DELETE')
                <button class="btn-ec-danger" type="submit" style="width:100%">
                    <i class="bi bi-trash3"></i> Excluir produto
                </button>
            </form>
        </div>
    </div>

</div>

@endsection
