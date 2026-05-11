@extends('layouts.app')
@section('title', 'Pedido #' . str_pad($order->id, 5, '0', STR_PAD_LEFT))

@push('styles')
<style>
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 768px) {
        .detail-grid { grid-template-columns: 1fr; }
    }

    .panel {
        background: #fff;
        border: 1px solid #ddd;
        margin-bottom: 16px;
    }

    .panel-header {
        padding: 12px 16px;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
        font-size: 0.875rem;
        background: #f5f5f5;
    }

    .panel-body { padding: 16px; }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        font-size: 0.875rem;
        border-bottom: 1px solid #eee;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #666; }
    .info-value { font-weight: 600; color: #333; }

    .history-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 10px 16px;
        border-bottom: 1px solid #eee;
        font-size: 0.875rem;
    }
    .history-item:last-child { border-bottom: none; }
    .history-status { font-weight: 600; color: #333; }
    .history-desc   { font-size: 0.78rem; color: #888; margin-top: 2px; }
    .history-date   { font-size: 0.75rem; color: #888; white-space: nowrap; margin-left: 12px; }
</style>
@endpush

@section('content')

<div style="font-size:.8rem;color:#666;margin-bottom:8px;">
    <a href="{{ route('orders.index') }}" style="color:#0066cc;text-decoration:none;">Meus Pedidos</a>
    &rsaquo; Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
</div>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="ec-page-title">Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
    <a href="{{ route('orders.index') }}" class="btn-ec-ghost">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
</div>

<div class="detail-grid">

    {{-- COLUNA PRINCIPAL --}}
    <div>

        {{-- ITENS DO PEDIDO --}}
        <div class="panel">
            <div class="panel-header">Itens do pedido</div>
            <table class="ec-table">
                <thead>
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
                        <td>{{ $item->product?->nome ?? 'Produto removido' }}</td>
                        <td class="text-center">{{ $item->quantidade }}</td>
                        <td class="text-end">R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                        <td class="text-end">R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding:30px;text-align:center;color:#888;">Sem itens.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end" style="padding:12px 16px;font-weight:bold;border-top:2px solid #ddd;">Total</td>
                        <td class="text-end" style="padding:12px 16px;font-weight:bold;border-top:2px solid #ddd;">
                            R$ {{ number_format($order->total, 2, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- HISTÓRICO DE STATUS --}}
        <div class="panel">
            <div class="panel-header">Histórico de status</div>
            @forelse($order->statusHistory as $history)
                <div class="history-item">
                    <div>
                        <div class="history-status">
                            {{ ucfirst(str_replace('_', ' ', $history->status)) }}
                        </div>
                        @if($history->descricao)
                            <div class="history-desc">{{ $history->descricao }}</div>
                        @endif
                    </div>
                    <div class="history-date">
                        {{ $history->created_at?->format('d/m/Y H:i') ?? '—' }}
                    </div>
                </div>
            @empty
                <div style="padding:24px;text-align:center;color:#888;font-size:.875rem;">
                    Sem histórico.
                </div>
            @endforelse
        </div>

    </div>

    {{-- COLUNA LATERAL --}}
    <div>
        <div class="panel">
            <div class="panel-header">Informações</div>
            <div class="panel-body">

                <div class="info-row">
                    <span class="info-label">Pedido</span>
                    <span class="info-value">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Data</span>
                    <span class="info-value">{{ $order->created_at?->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span>
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
                        <span class="ec-badge {{ $badgeClass }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Subtotal</span>
                    <span class="info-value">
                        R$ {{ number_format($order->total - ($order->frete_valor ?? 0), 2, ',', '.') }}
                    </span>
                </div>
                @if($order->frete_valor !== null)
                <div class="info-row">
                    <span class="info-label">Frete</span>
                    <span class="info-value">
                        @if($order->frete_valor == 0)
                            <span style="color:#067D62;">Grátis</span>
                        @else
                            R$ {{ number_format($order->frete_valor, 2, ',', '.') }}
                        @endif
                    </span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Total</span>
                    <span class="info-value">R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                </div>

                @if($order->observacoes)
                <div class="info-row">
                    <span class="info-label">Observações</span>
                    <span class="info-value">{{ $order->observacoes }}</span>
                </div>
                @endif

                @if($order->status === 'pendente' || $order->status === 'confirmado')
                    <div style="margin-top:16px;">
                        <form action="{{ route('orders.cancel', $order) }}" method="POST"
                              onsubmit="return confirm('Cancelar este pedido?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-ec-danger" style="width:100%;">
                                <i class="bi bi-x-lg"></i> Cancelar pedido
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>

        {{-- ENTREGA --}}
        @if($order->endereco_entrega || $order->data_entrega_prevista)
        <div class="panel">
            <div class="panel-header"><i class="bi bi-truck" style="margin-right:6px;"></i>Entrega</div>
            <div class="panel-body">
                @if($order->endereco_entrega)
                <div class="info-row" style="flex-direction:column;align-items:flex-start;gap:4px;">
                    <span class="info-label">Endereço</span>
                    <span class="info-value" style="font-weight:normal;color:#333;font-size:0.8rem;line-height:1.5;">
                        {{ $order->endereco_entrega }}
                    </span>
                </div>
                @endif
                @if($order->data_entrega_prevista)
                <div class="info-row">
                    <span class="info-label">Previsão</span>
                    <span class="info-value" style="color:#067D62;">
                        <i class="bi bi-calendar3"></i>
                        {{ \Carbon\Carbon::parse($order->data_entrega_prevista)->format('d/m/Y') }}
                    </span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Situação</span>
                    <span>
                        @php
                            $deliveryStatus = match($order->status) {
                                'pendente'      => ['label' => 'Aguardando confirmação', 'icon' => 'bi-clock',          'color' => '#e67e00'],
                                'confirmado'    => ['label' => 'Pedido confirmado',      'icon' => 'bi-check-circle',   'color' => '#0066cc'],
                                'em_preparacao' => ['label' => 'Em preparação',          'icon' => 'bi-box-seam',       'color' => '#0066cc'],
                                'enviado'       => ['label' => 'A caminho',              'icon' => 'bi-truck',          'color' => '#6c757d'],
                                'entregue'      => ['label' => 'Entregue',               'icon' => 'bi-house-check',    'color' => '#067D62'],
                                'cancelado'     => ['label' => 'Cancelado',              'icon' => 'bi-x-circle',       'color' => '#cc0000'],
                                default         => ['label' => ucfirst($order->status),  'icon' => 'bi-circle',         'color' => '#888'],
                            };
                        @endphp
                        <span style="display:inline-flex;align-items:center;gap:5px;font-weight:600;font-size:0.8rem;color:{{ $deliveryStatus['color'] }};">
                            <i class="bi {{ $deliveryStatus['icon'] }}"></i>
                            {{ $deliveryStatus['label'] }}
                        </span>
                    </span>
                </div>
            </div>
        </div>
        @endif

        {{-- PAGAMENTO --}}
        @if($order->pagamento_ultimos_digitos)
        <div class="panel">
            <div class="panel-header"><i class="bi bi-credit-card" style="margin-right:6px;"></i>Pagamento</div>
            <div class="panel-body">
                @if($order->pagamento_bandeira && $order->pagamento_bandeira !== 'outro')
                <div class="info-row">
                    <span class="info-label">Bandeira</span>
                    <span class="info-value">{{ ucfirst($order->pagamento_bandeira) }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Cartão</span>
                    <span class="info-value" style="font-family:monospace;">
                        •••• •••• •••• {{ $order->pagamento_ultimos_digitos }}
                    </span>
                </div>
                @if($order->pagamento_titular)
                <div class="info-row">
                    <span class="info-label">Titular</span>
                    <span class="info-value">{{ $order->pagamento_titular }}</span>
                </div>
                @endif
                @if($order->pagamento_validade)
                <div class="info-row">
                    <span class="info-label">Validade</span>
                    <span class="info-value">{{ $order->pagamento_validade }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

    </div>

</div>

@endsection
