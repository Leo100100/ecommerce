<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->string('asaas_payment_id')->nullable();
            $table->string('asaas_invoice_url')->nullable();
            $table->string('asaas_bank_slip_url')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'asaas_payment_id',
                'asaas_invoice_url',
                'asaas_bank_slip_url',
            ]);

        });
    }
};
