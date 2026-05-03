@extends('layouts.app')
@section('title', 'Pedido #' . $order->id)

@section('content')

<div class="d-flex align-items-center mb-4 gap-2">
    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary">← Voltar</a>
    <h4 class="mb-0">Pedido #{{ $order->id }}</h4>
</div>

@if(session('success')) <div class="alert alert-success">
{{ session('success') }} </div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        {{-- ITENS --}}
        <div class="card mb-4">
            <div class="card-header">Itens do pedido</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th class="text-center">Qtd</th>
                            <th class="text-end">Preço unit.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                        <tr>
                            <td>{{ $item->product->nome }}</td>
                            <td class="text-center">{{ $item->quantidade }}</td>
                            <td class="text-end">
                                R$ {{ number_format($item->preco, 2, ',', '.') }}
                            </td>
                            <td class="text-end">
                                R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                Sem itens.
                            </td>
                        </tr>
                        @endforelse
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

```
    {{-- HISTÓRICO --}}
    <div class="card">
        <div class="card-header">Histórico de status</div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse($order->statusHistory as $history)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold">
                            {{ ucfirst(str_replace('_', ' ', $history->status)) }}
                        </span>

                        @if($history->descricao)
                            <div class="text-muted small">
                                {{ $history->descricao }}
                            </div>
                        @endif
                    </div>

                    <span class="text-muted small">
                        {{ $history->created_at->format('d/m/Y H:i') }}
                    </span>
                </li>
                @empty
                <li class="list-group-item text-muted text-center py-3">
                    Sem histórico.
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

{{-- SIDEBAR --}}
<div class="col-lg-4">
    <div class="card">
        <div class="card-header">Informações</div>
        <div class="card-body">
            <dl class="mb-3">
                <dt>Cliente</dt>
                <dd>{{ $order->user->name }}</dd>

                <dt>Status</dt>
                <dd>
                    <span class="badge bg-primary">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </dd>

                <dt>Data</dt>
                <dd>{{ $order->created_at->format('d/m/Y H:i') }}</dd>

                @if($order->observacoes)
                    <dt>Observações</dt>
                    <dd>{{ $order->observacoes }}</dd>
                @endif
            </dl>

            <hr>

            {{-- ATUALIZAR STATUS --}}
            <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-2">
                    <label class="form-label">Atualizar status</label>
                    <select name="status" class="form-select">
                        <option value="pendente">Pendente</option>
                        <option value="confirmado">Confirmado</option>
                        <option value="em_preparacao">Em preparação</option>
                        <option value="enviado">Enviado</option>
                        <option value="entregue">Entregue</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>

                <button class="btn btn-primary w-100">
                    Atualizar
                </button>
            </form>

            {{-- CANCELAR --}}
            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="mt-2">
                @csrf
                @method('PATCH')

                <button class="btn btn-danger w-100">
                    Cancelar Pedido
                </button>
            </form>

        </div>
    </div>
</div>
```

</div>
@endsection
