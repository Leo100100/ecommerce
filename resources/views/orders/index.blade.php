@extends('layouts.app')
@section('title', 'Pedidos')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0">Pedidos</h4>

    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        Novo Pedido
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                    <td>
                        @php
                            $badgeMap = [
                                'pendente'      => 'warning',
                                'confirmado'    => 'info',
                                'em_preparacao' => 'primary',
                                'enviado'       => 'secondary',
                                'entregue'      => 'success',
                                'cancelado'     => 'danger',
                            ];
                            $color = $badgeMap[$order->status] ?? 'light';
                        @endphp
                        <span class="badge bg-{{ $color }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>

                    <td class="text-center">

                        {{-- Ver --}}
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                            Ver
                        </a>

                        {{-- Atualizar status --}}
                        <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')

                            <select name="status" class="form-select form-select-sm d-inline w-auto">
                                <option value="confirmado">Confirmar</option>
                                <option value="em_preparacao">Preparação</option>
                                <option value="enviado">Enviar</option>
                                <option value="entregue">Entregar</option>
                            </select>

                            <button class="btn btn-sm btn-warning">OK</button>
                        </form>

                        {{-- Cancelar --}}
                        <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')

                            <button class="btn btn-sm btn-danger">Cancelar</button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Nenhum pedido encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="card-footer">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection
