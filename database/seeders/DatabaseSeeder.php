<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Admin',
            'email' => 'admin@example.com',
        ]);

        User::updateOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name'     => 'Seller',
                'email'    => 'seller@example.com',
                'password' => Hash::make('12345678'),
                'vendedor' => true,
                'cnpj'     => '00000000000000',
            ]
        );

        $this->command->info('Usuario criado: admin@example.com / senha: password');
        $this->command->info('Vendedor criado: seller@example.com / senha: 12345678');

        $this->call([
            ProductSeeder::class,
        ]);

    }


}
