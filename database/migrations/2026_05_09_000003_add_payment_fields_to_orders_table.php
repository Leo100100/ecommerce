<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('pagamento_titular', 100)->nullable()->after('data_entrega_prevista');
            $table->string('pagamento_bandeira', 20)->nullable()->after('pagamento_titular');
            $table->string('pagamento_ultimos_digitos', 4)->nullable()->after('pagamento_bandeira');
            $table->string('pagamento_validade', 5)->nullable()->after('pagamento_ultimos_digitos');
            $table->decimal('frete_valor', 8, 2)->nullable()->after('pagamento_validade');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'pagamento_titular',
                'pagamento_bandeira',
                'pagamento_ultimos_digitos',
                'pagamento_validade',
                'frete_valor',
            ]);
        });
    }
};
