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
                </tr>
            </thead>

            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product->nome ?? $item->product->name }}
                    </td>

                    <td class="text-center">
                        {{ $item->quantidade }}
                    </td>

                    <td class="text-end">
                        R$ {{ number_format($item->preco, 2, ',', '.') }}
                    </td>

                    <td class="text-end">
                        R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>

            <tfoot class="table-light">
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total</td>
                    <td class="text-end fw-bold">
                        R$ {{ number_format($order->total, 2, ',', '.') }}
                    </td>
                </tr>
            </tfoot>

        </table>
    </div>
</div>

@endif

@endsection
