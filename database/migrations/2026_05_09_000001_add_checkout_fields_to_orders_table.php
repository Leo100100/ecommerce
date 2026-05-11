<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('endereco_entrega')->nullable()->after('observacoes');
            $table->date('data_entrega_prevista')->nullable()->after('endereco_entrega');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['endereco_entrega', 'data_entrega_prevista']);
        });
    }
};
