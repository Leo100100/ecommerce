<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['nome' => 'Camiseta Básica Branca', 'descricao' => 'Camiseta 100% algodão, lavagem fácil.', 'preco' => 49.90, 'estoque' => 100],
            ['nome' => 'Calça Jeans Slim', 'descricao' => 'Calça jeans corte slim fit.', 'preco' => 199.90, 'estoque' => 50],
            ['nome' => 'Tênis Running Pro', 'descricao' => 'Tênis para corrida com amortecimento.', 'preco' => 349.90, 'estoque' => 30],
            ['nome' => 'Mochila Urbana 20L', 'descricao' => 'Mochila resistente para uso diário.', 'preco' => 129.90, 'estoque' => 40],
            ['nome' => 'Óculos de Sol Esportivo', 'descricao' => 'Lentes polarizadas UV400.', 'preco' => 89.90, 'estoque' => 25],
            ['nome' => 'Relógio Digital Esportivo', 'descricao' => 'Cronômetro, alarme e resistente à água.', 'preco' => 259.90, 'estoque' => 20],
            ['nome' => 'Fone Bluetooth Over-Ear', 'descricao' => 'Cancelamento de ruído ativo.', 'preco' => 399.90, 'estoque' => 15],
            ['nome' => 'Garrafa Térmica 500ml', 'descricao' => 'Mantém temperatura por 12h.', 'preco' => 59.90, 'estoque' => 80],
        ];

        foreach ($products as $data) {
            Product::create(array_merge($data, ['ativo' => true]));
        }
    }
}
