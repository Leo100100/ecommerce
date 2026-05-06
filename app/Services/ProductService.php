<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{


    public function decrementStock(Product $product, int $quantity): void
    {

        if ($quantity <= 0) {
            throw new \Exception('Quantidade inválida');
        }

        if ($product->estoque < $quantity) {
            throw new \Exception("Estoque insuficiente para o produto {$product->nome}");
        }

        // ✔ operação segura no banco
        $product->decrement('estoque', $quantity);
    }
    

    /**
     * TODO (candidato): implementar lógica de atualização de estoque.
     */






}
