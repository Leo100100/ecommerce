<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderStatusHistory;

class OrderService
{
    /**
     * TODO (candidato): implementar criação de pedido com itens e validação de estoque.
     */
    public function createOrder(array $data, array $items): Order
    {
        throw new \Exception('Not implemented');
    }

    /**
     * TODO (candidato): implementar transição de status com regras de negócio.
     */
    public function updateStatus(Order $order, string $status, ?string $descricao = null): Order
    {
        throw new \Exception('Not implemented');
    }
}
