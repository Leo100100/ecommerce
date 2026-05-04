<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * TODO (candidato): implementar lógica de atualização de estoque.
     */
    
    public function decrementStock(Product $product, int $quantity): void
    {
        throw new \Exception('Not implemented');
    }
}
