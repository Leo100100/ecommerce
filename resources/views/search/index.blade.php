@extends('layouts.app')
@section('title', $q !== '' ? 'Resultados: ' . $q : 'Todos os Produtos')

@push('styles')
<style>
    .catalog-wrap {
        display: flex;
        gap: 25px;
        align-items: flex-start;
    }

    /* SIDEBAR DE FILTROS */
    .filter-sidebar {
        width: 200px;
        min-width: 200px;
        flex-shrink: 0;
    }

    .filter-panel {
        background: #fff;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }

    .filter-panel-title {
        font-size: 0.8rem;
        font-weight: bold;
        color: #555;
        padding: 10px 12px;
        border-bottom: 1px solid #ddd;
        background: #f5f5f5;
    }

    .filter-panel-body {
        padding: 12px;
    }

    .filter-breadcrumb {
        font-size: 0.78rem;
        color: #666;
        line-height: 1.8;
    }

    .filter-breadcrumb a {
        color: #0066cc;
        text-decoration: none;
    }

    .filter-breadcrumb .crumb-current {
        color: #333;
        font-weight: 600;
    }

    .filter-label {
        display: block;
        font-size: 0.8rem;
        color: #555;
        margin-bottom: 4px;
    }

    .filter-input {
        width: 100%;
        border: 1px solid #ccc;
        padding: 6px 8px;
        font-size: 0.8rem;
        color: #333;
        background: #fff;
        outline: none;
        margin-bottom: 8px;
    }

    .filter-input:focus { border-color: #0066cc; }

    .filter-btn {
        width: 100%;
        background: #0066cc;
        color: #fff;
        border: none;
        padding: 7px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
    }

    .filter-clear {
        display: block;
        text-align: center;
        font-size: 0.75rem;
        color: #0066cc;
        text-decoration: none;
        margin-top: 8px;
    }

    /* CONTEÚDO PRINCIPAL */
    .catalog-main { flex: 1; min-width: 0; }

    .catalog-toolbar {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .catalog-toolbar-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin: 0;
        flex: 1;
    }

    .result-count {
        font-size: 0.78rem;
        color: #666;
        padding: 4px 10px;
        background: #eee;
        white-space: nowrap;
    }

    .sort-select {
        border: 1px solid #ccc;
        padding: 6px 10px;
        font-size: 0.8rem;
        color: #333;
        background: #fff;
        cursor: pointer;
        outline: none;
    }

    /* GRID */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 20px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #ddd;
        display: flex;
        flex-direction: column;
    }

    .product-card-thumb {
        background: #f3f4f6;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #bbb;
        font-size: 3rem;
        border-bottom: 1px solid #eee;
    }

    .product-card-body {
        padding: 14px 12px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-card-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
        line-height: 1.4;
    }

    .product-card-price {
        font-size: 1.05rem;
        font-weight: bold;
        color: #333;
        margin-top: auto;
        padding-top: 12px;
    }

    .product-card-actions {
        display: flex;
        gap: 6px;
        padding: 8px 10px;
        border-top: 1px solid #eee;
    }

    .btn-card-cart {
        flex: 1;
        background: #0066cc;
        color: #fff;
        border: none;
        padding: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .btn-card-view {
        background: transparent;
        color: #555;
        border: 1px solid #ccc;
        padding: 6px 8px;
        font-size: 0.8rem;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .empty-state {
        grid-column: 1 / -1;
        padding: 60px 20px;
        text-align: center;
        color: #888;
        background: #fff;
        border: 1px solid #ddd;
    }

    .pagination-wrap {
        display: flex;
        justify-content: flex-end;
    }

    mark {
        background: #FEF3C7;
        color: inherit;
        padding: 0 2px;
    }

    @media (max-width: 1024px) {
        .product-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 640px) {
        .catalog-wrap { flex-direction: column; }
        .filter-sidebar { width: 100%; }
        .product-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')

<div class="catalog-wrap">

    {{-- SIDEBAR FILTROS --}}
    <aside class="filter-sidebar">

        {{-- Breadcrumbs --}}
        <div class="filter-panel">
            <div class="filter-panel-title">Navegação</div>
            <div class="filter-panel-body">
                <div class="filter-breadcrumb">
                    <a href="{{ route('home') }}">Início</a><br>
                    @if($q !== '')
                        <a href="{{ route('search.index') }}">Produtos</a><br>
                        <span class="crumb-current">{{ Str::limit($q, 20) }}</span>
                    @else
                        <span class="crumb-current">Todos os produtos</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Filtro de preço --}}
        <div class="filter-panel">
            <div class="filter-panel-title">Filtrar por preço</div>
            <div class="filter-panel-body">
                <form action="{{ route('search.index') }}" method="GET">
                    @if($q !== '')
                        <input type="hidden" name="q" value="{{ $q }}">
                    @endif
                    <input type="hidden" name="sort" value="{{ $sort }}">

                    <label class="filter-label">Preço mínimo (R$)</label>
                    <input type="number" name="min_price" class="filter-input"
                           value="{{ $minPrice }}" min="0" step="0.01" placeholder="0,00">

                    <label class="filter-label">Preço máximo (R$)</label>
                    <input type="number" name="max_price" class="filter-input"
                           value="{{ $maxPrice }}" min="0" step="0.01" placeholder="Sem limite">

                    <button type="submit" class="filter-btn">Aplicar</button>
                </form>

                @if($minPrice !== null || $maxPrice !== null)
                    <a href="{{ route('search.index', array_filter(['q' => $q, 'sort' => $sort])) }}" class="filter-clear">
                        Limpar filtro
                    </a>
                @endif
            </div>
        </div>

    </aside>

    {{-- CONTEÚDO PRINCIPAL --}}
    <div class="catalog-main">

        <div class="catalog-toolbar">
            <h1 class="catalog-toolbar-title">
                @if($q !== '')
                    Resultados para "{{ $q }}"
                @else
                    Todos os produtos
                @endif
            </h1>

            <span class="result-count">
                {{ $products->total() }} {{ $products->total() == 1 ? 'produto' : 'produtos' }}
            </span>

            <form action="{{ route('search.index') }}" method="GET">
                @if($q !== '')
                    <input type="hidden" name="q" value="{{ $q }}">
                @endif
                @if($minPrice !== null)
                    <input type="hidden" name="min_price" value="{{ $minPrice }}">
                @endif
                @if($maxPrice !== null)
                    <input type="hidden" name="max_price" value="{{ $maxPrice }}">
                @endif
                <select name="sort" class="sort-select" onchange="this.form.submit()">
                    <option value="relevancia" {{ $sort === 'relevancia' ? 'selected' : '' }}>
                        {{ $q !== '' ? 'Relevância' : 'Ordenar' }}
                    </option>
                    <option value="preco_asc"  {{ $sort === 'preco_asc'  ? 'selected' : '' }}>Menor preço</option>
                    <option value="preco_desc" {{ $sort === 'preco_desc' ? 'selected' : '' }}>Maior preço</option>
                    <option value="nome_asc"   {{ $sort === 'nome_asc'   ? 'selected' : '' }}>A → Z</option>
                    <option value="nome_desc"  {{ $sort === 'nome_desc'  ? 'selected' : '' }}>Z → A</option>
                    <option value="recentes"   {{ $sort === 'recentes'   ? 'selected' : '' }}>Mais recentes</option>
                </select>
            </form>
        </div>

        <div class="product-grid">
            @forelse($products as $product)
            <div class="product-card">
                <div class="product-card-thumb">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="product-card-body">
                    <div class="product-card-name">
                        @if($q !== '')
                            {!! preg_replace(
                                '/(' . preg_quote(e($q), '/') . ')/iu',
                                '<mark>$1</mark>',
                                e($product->nome)
                            ) !!}
                        @else
                            {{ $product->nome }}
                        @endif
                    </div>
                    <div class="product-card-price">
                        R$ {{ number_format($product->preco, 2, ',', '.') }}
                    </div>
                </div>
                <div class="product-card-actions">
                    <form action="{{ route('orders.addProduct') }}" method="POST" style="flex:1;margin:0;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn-card-cart">
                            <i class="bi bi-cart-plus"></i> Adicionar ao Carrinho
                        </button>
                    </form>
                    <a href="{{ route('products.show', $product) }}" class="btn-card-view" title="Ver detalhes">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="bi bi-search" style="font-size:2.5rem;display:block;margin-bottom:12px;"></i>
                @if($q !== '')
                    Nenhum resultado para <strong>"{{ $q }}"</strong>.
                @else
                    Nenhum produto disponível no momento.
                @endif
            </div>
            @endforelse
        </div>

        @if($products->hasPages())
        <div class="pagination-wrap">
            {{ $products->links() }}
        </div>
        @endif

    </div>
</div>

@endsection
