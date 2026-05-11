@extends('layouts.app')
@section('title', 'Meus Pedidos')

@push('styles')
<style>
    .toolbar { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
    .toolbar-title { font-size: 1.2rem; font-weight: bold; margin: 0; flex: 1; }

    .order-id   { font-weight: 600; color: #0066cc; font-size: 0.875rem; }
    .order-date { font-size: 0.75rem; color: #888; }

    .total-cell { font-weight: bold; font-size: 0.95rem; }

    .action-cell { display: flex; gap: 6px; align-items: center; justify-content: flex-start; }

    .table-card {
        background: #fff;
        border: 1px solid #ddd;
        overflow: hidden;
    }
    .pagination-wrap { padding: 16px 20px; border-top: 1px solid #ddd; display: flex; justify-content: flex-end; }
</style>
@endpush

@section('content')

<div class="toolbar">
    <h1 class="toolbar-title">Pedidos</h1>
    <a href="{{ route('products.index') }}" class="btn-ec-ghost">
        <i class="bi bi-bag-plus"></i> Continuar comprando
    </a>
</div>

<div class="table-card">
    <table class="ec-table">
        <thead>
            <tr>
                <th>Pedido</th>
                <th>Total</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            @php
                $badgeMap = [
                    'pendente'      => 'ec-badge-warning',
                    'confirmado'    => 'ec-badge-info',
                    'em_preparacao' => 'ec-badge-info',
                    'enviado'       => 'ec-badge-muted',
                    'entregue'      => 'ec-badge-success',
                    'cancelado'     => 'ec-badge-danger',
                ];
                $badgeClass = $badgeMap[$order->status] ?? 'ec-badge-muted';
            @endphp
            <tr>
                <td>
                    <div class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="order-date">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                </td>
                <td class="total-cell">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                <td>
                    <span class="ec-badge {{ $badgeClass }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </td>
                <td>
                    <div class="action-cell">
                        <a href="{{ route('orders.show', $order) }}" class="btn-ec-ghost">
                            <i class="bi bi-eye"></i> Ver
                        </a>

                        @if($order->status === 'pendente' || $order->status === 'confirmado')
                            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="m-0"
                                  onsubmit="return confirm('Cancelar pedido #{{ $order->id }}?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-ec-danger">
                                    <i class="bi bi-x-lg"></i> Cancelar
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding:60px; text-align:center; color:#888;">
                    <i class="bi bi-receipt" style="font-size:2.5rem; display:block; margin-bottom:12px;"></i>
                    Você ainda não tem pedidos.
                    <br>
                    <a href="{{ route('products.index') }}" class="btn-ec-primary mt-3" style="display:inline-flex;">
                        <i class="bi bi-bag-plus"></i> Ver produtos
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($orders, 'hasPages') && $orders->hasPages())
    <div class="pagination-wrap">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection
