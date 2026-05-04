@extends('layouts.app')

@section('title', 'Carrinho')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0">Meu Carrinho</h4>

    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
        Voltar para pedidos
    </a>
</div>

@if(!$order || $order->items->isEmpty())

    <div class="alert alert-info">
        Seu carrinho está vazio.
    </div>

@else

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">

            <thead class="table-dark">
                <tr>
                    <th>Produto</th>
                    <th class="text-center">Quantidade</th>
                    <th class="text-end">Preço</th>
                    <th class="text-end">Subtotal</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>
@foreach($order->items as $item)
<tr>

    <td>
        {{ $item->product->nome ?? $item->product->name }}
    </td>

    {{-- QUANTIDADE COM CONTROLE --}}
    <td class="text-center">

        <div class="d-flex justify-content-center align-items-center gap-2">

            {{-- DIMINUIR --}}
            <form action="{{ route('cart.update', $item->product_id) }}" method="POST">
                @csrf
                <input type="hidden" name="quantidade" value="{{ $item->quantidade - 1 }}">
                <button class="btn btn-sm btn-outline-secondary">-</button>
            </form>

            <span>{{ $item->quantidade }}</span>

            {{-- AUMENTAR --}}
            <form action="{{ route('cart.update', $item->product_id) }}" method="POST">
                @csrf
                <input type="hidden" name="quantidade" value="{{ $item->quantidade + 1 }}">
                <button class="btn btn-sm btn-outline-secondary">+</button>
            </form>

        </div>

    </td>

    <td class="text-end">
        R$ {{ number_format($item->preco, 2, ',', '.') }}
    </td>

    <td class="text-end">
        R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}
    </td>

    {{-- REMOVER --}}
    <td class="text-center">
        <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-outline-danger">
                ❌
            </button>
        </form>
    </td>

</tr>
@endforeach
</tbody>
<div class="d-flex justify-content-between align-items-center mt-3">

    <h5 class="mb-0">
        Total: R$ {{ number_format($order->total, 2, ',', '.') }}
    </h5>

    <a href="#" class="btn btn-success">
        Finalizar compra
    </a>

</div>

            <tfoot class="table-light">
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total</td>
                    <td class="text-end fw-bold">
                        R$ {{ number_format($order->total, 2, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>

        </table>
    </div>
</div>

@endif

@endsection
