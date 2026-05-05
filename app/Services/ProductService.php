<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * TODO (candidato): implementar lógica de atualização de estoque.
     */

    use Illuminate\Support\Facades\DB;

    public function decrementStock(Product $product, int $quantity): void
    {
        if ($product->estoque < $quantity) {
            throw new \Exception("Estoque insuficiente para o produto {$product->nome}");
        }

        $product->decrement('estoque', $quantity);
        }

        
}
