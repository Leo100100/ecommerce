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
        return DB::transaction(function () use ($data, $items) {

            $total = 0;


            foreach ($items as $item) {
                $product = $item['product'];

                if ($product->estoque < $item['quantidade']) {
                    throw new \Exception("Produto {$product->nome} sem estoque suficiente");
                }

                $total += $product->preco * $item['quantidade'];
            }

            // cria pedido
            $order = Order::create([
                'user_id' => $data['user_id'],
                'status' => 'pendente',
                'total' => $total
            ]);

            //cria itens + baixa estoque
            foreach ($items as $item) {

                $product = $item['product'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantidade' => $item['quantidade'],
                    'preco' => $product->preco
                ]);

                // baixa estoque
                app(ProductService::class)->decrementStock($product, $item['quantidade']);
            }

            // histórico inicial
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'pendente',
                'descricao' => 'Pedido criado'
            ]);

            return $order;
        });
    }
    public function updateStatus(Order $order, string $status, ?string $descricao = null): Order
    {
        $validTransitions = [
            'pendente' => ['pago', 'cancelado'],
            'pago' => ['enviado'],
            'enviado' => ['entregue'],
        ];

        if (
            !isset($validTransitions[$order->status]) ||
            !in_array($status, $validTransitions[$order->status])
        ) {
            throw new \Exception("Transição de status inválida");
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
