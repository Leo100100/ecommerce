@extends('layouts.app')
@section('title', 'Produtos')

@push('styles')
<style>
    .toolbar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .toolbar-title { font-size: 1.2rem; font-weight: bold; margin: 0; flex: 1; }

    .search-bar {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        background: #fff;
        overflow: hidden;
    }
    .search-bar input {
        border: none;
        outline: none;
        padding: 8px 12px;
        font-size: 0.875rem;
        width: 240px;
        background: transparent;
    }
    .search-bar i { padding: 0 10px; color: #888; }

    .product-count {
        font-size: 0.78rem;
        color: #666;
        padding: 4px 10px;
        background: #eee;
    }

    .table-card {
        background: #fff;
        border: 1px solid #ddd;
        overflow: hidden;
    }

    .ec-table .product-thumb {
        width: 40px;
        height: 40px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .ec-table .product-name-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .ec-table .product-name-text { font-weight: 600; font-size: 0.875rem; }
    .ec-table .product-id-text  { font-size: 0.72rem; color: #888; }

    .price-cell { font-weight: bold; font-size: 0.95rem; }
    .price-cell small { font-size: 0.7rem; font-weight: normal; color: #888; }

    .stock-cell { font-size: 0.85rem; }
    .stock-low  { color: #B45309; font-weight: 600; }
    .stock-ok   { color: #067D62; font-weight: 600; }

    .action-cell { display: flex; gap: 6px; align-items: center; justify-content: center; }

    .pagination-wrap {
        padding: 16px 20px;
        border-top: 1px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
</style>
@endpush

@section('content')

<div class="toolbar">
    <h1 class="toolbar-title">Produtos</h1>
    <span class="product-count">{{ $products->total() ?? $products->count() }} produtos</span>
    <div class="search-bar">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Buscar produto..." id="tableSearch">
    </div>
    <a href="{{ route('products.create') }}" class="btn-ec-primary">
        <i class="bi bi-plus-lg"></i> Novo Produto
    </a>
</div>

<div class="table-card">
    <table class="ec-table" id="productsTable">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <div class="product-name-cell">
                        <div class="product-thumb"><i class="bi bi-box-seam"></i></div>
                        <div>
                            <div class="product-name-text">{{ $product->nome }}</div>
                            <div class="product-id-text">#{{ $product->id }}</div>
                        </div>
                    </div>
                </td>
                <td class="price-cell">
                    R$ {{ number_format($product->preco, 2, ',', '.') }}
                    <br><small>à vista</small>
                </td>
                <td class="stock-cell">
                    @if(isset($product->estoque))
                        <span class="{{ $product->estoque < 5 ? 'stock-low' : 'stock-ok' }}">
                            {{ $product->estoque }} un.
                        </span>
                    @else
                        <span style="color:#888;">—</span>
                    @endif
                </td>
                <td>
                    @if($product->ativo)
                        <span class="ec-badge ec-badge-success">Ativo</span>
                    @else
                        <span class="ec-badge ec-badge-muted">Inativo</span>
                    @endif
                </td>
                <td>
                    <div class="action-cell">
                        {{-- <form action="{{ route('orders.addProduct') }}" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn-ec-primary" title="Adicionar ao carrinho">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </form> --}}
                        <a href="{{ route('products.show', $product) }}" class="btn-ec-ghost" title="Visualizar">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="btn-ec-outline" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="m-0"
                              onsubmit="return confirm('Excluir «{{ $product->nome }}»?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn-ec-danger" type="submit" title="Excluir">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:60px; text-align:center; color:#888;">
                    <i class="bi bi-box-seam" style="font-size:2.5rem; display:block; margin-bottom:12px;"></i>
                    Nenhum produto cadastrado.
                    <br><a href="{{ route('products.create') }}" class="btn-ec-primary mt-3" style="display:inline-flex;">
                        <i class="bi bi-plus-lg"></i> Cadastrar agora
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($products, 'hasPages') && $products->hasPages())
    <div class="pagination-wrap">
        {{ $products->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.getElementById('tableSearch')?.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#productsTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
@endpush

@endsection
