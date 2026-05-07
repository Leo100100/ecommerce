
<h2>Pedido #{{ $order->id }}</h2>

<p><strong>Cliente:</strong> {{ $order->user->name }}</p>
<p><strong>Status:</strong> {{ $order->status }}</p>

<hr>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Produto</th>
            <th>Qtd</th>
            <th>Preço</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantidade }}</td>
            <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
            <td>R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Total: R$ {{ number_format($order->total, 2, ',', '.') }}</h3>

