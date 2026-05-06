<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatus;

class OrderService
{
    /**
     * TODO (candidato): implementar criação de pedido com itens e validação de estoque.
     */
    public function createOrder(array $data, array $items): Order
    {
        return DB::transaction(function () use ($data, $items) {

            if (empty($items)) {
                throw new \Exception('Pedido sem itens');
            }

            $total = 0;

            // valida estoque antes
            foreach ($items as $item) {

                $product = $item['product'];
                $quantidade = $item['quantidade'];

                if ($product->estoque < $quantidade) {
                    throw new \Exception("Produto {$product->nome} sem estoque suficiente");
                }

                $total += $product->preco * $quantidade;
            }


            $order = Order::create([
                'user_id' => $data['user_id'],
                'status' => OrderStatus::PENDENTE,
                'total' => $total
            ]);


            foreach ($items as $item) {

                $product = $item['product'];
                $quantidade = $item['quantidade'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantidade' => $quantidade,
                    'preco' => $product->preco
                ]);

                app(ProductService::class)->decrementStock($product, $quantidade);
            }


            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => OrderStatus::PENDENTE,
                'descricao' => 'Pedido criado'
            ]);

            return $order;
        });
    }
    public function updateStatus(Order $order, string $status, ?string $descricao = null): Order
    {

        $transitions = [
            OrderStatus::PENDENTE => [OrderStatus::AGUARDANDO, OrderStatus::CANCELADO],
            OrderStatus::AGUARDANDO => [OrderStatus::PAGO, OrderStatus::CANCELADO],
            OrderStatus::PAGO => [OrderStatus::ENVIADO],
            OrderStatus::ENVIADO => [OrderStatus::ENTREGUE],
        ];

        $current = $order->status;

        if (!isset($transitions[$current]) || !in_array($status, $transitions[$current])) {
            throw new \Exception("Transição inválida: {$current} → {$status}");
        }


        $order->update([
            'status' => $status
        ]);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => $status,
            'descricao' => $descricao
        ]);

        return $order;
    }

}
