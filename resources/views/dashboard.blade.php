@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="d-flex align-items-center mb-4">
    <h4 class="mb-0">Dashboard</h4>
</div>

{{-- BOAS-VINDAS --}}

<div class="card mb-4">
    <div class="card-header">Bem-vindo, {{ Auth::user()->name }}!</div>
    <div class="card-body">
        <p class="text-muted mb-0">
            Utilize o menu lateral para navegar entre <strong>Produtos</strong> e <strong>Pedidos</strong>.
        </p>
    </div>
</div>

{{-- PRODUTOS --}}

<div class="card">
    <div class="card-header">Produtos recentes</div>
    <div class="card-body">
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">

```
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            {{ $product->nome ?? $product->name }}
                        </h5>

                        <p class="text-muted small">
                            {{ $product->descricao ?? 'Sem descrição' }}
                        </p>

                        <p class="fw-bold mt-auto">
                            R$ {{ number_format($product->preco ?? $product->price, 2, ',', '.') }}
                        </p>

                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary mt-2">
                            Ver Produto
                        </a>
                        <form action="{{ route('orders.addProduct') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <button class="btn btn-success btn-sm w-100">
                                Adicionar ao carrinho
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Nenhum produto encontrado.
                </div>
            </div>
        @endforelse
    </div>
</div>

```

</div>

@endsection
