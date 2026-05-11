<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $seller_id = User::where('email', 'seller@example.com')->value('id');

        $products = [
            ['user_id' => $seller_id,'nome' => 'Camiseta Básica Branca', 'descricao' => 'Camiseta 100% algodão, lavagem fácil.', 'preco' => 49.90, 'estoque' => 100],
            ['user_id' => $seller_id,'nome' => 'Calça Jeans Slim', 'descricao' => 'Calça jeans corte slim fit.', 'preco' => 199.90, 'estoque' => 50],
            ['user_id' => $seller_id,'nome' => 'Tênis Running Pro', 'descricao' => 'Tênis para corrida com amortecimento.', 'preco' => 349.90, 'estoque' => 30],
            ['user_id' => $seller_id,'nome' => 'Mochila Urbana 20L', 'descricao' => 'Mochila resistente para uso diário.', 'preco' => 129.90, 'estoque' => 40],
            ['user_id' => $seller_id,'nome' => 'Óculos de Sol Esportivo', 'descricao' => 'Lentes polarizadas UV400.', 'preco' => 89.90, 'estoque' => 25],
            ['user_id' => $seller_id,'nome' => 'Relógio Digital Esportivo', 'descricao' => 'Cronômetro, alarme e resistente à água.', 'preco' => 259.90, 'estoque' => 20],
            ['user_id' => $seller_id,'nome' => 'Fone Bluetooth Over-Ear', 'descricao' => 'Cancelamento de ruído ativo.', 'preco' => 399.90, 'estoque' => 15],
            ['user_id' => $seller_id,'nome' => 'Garrafa Térmica 500ml', 'descricao' => 'Mantém temperatura por 12h.', 'preco' => 59.90, 'estoque' => 80],
        ];



        foreach ($products as $data) {
            Product::create(array_merge($data, ['ativo' => true]));
        }
    }
}
