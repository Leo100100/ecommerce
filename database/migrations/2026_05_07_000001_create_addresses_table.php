<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('apelido', 60)->default('Casa');
            $table->string('cep', 9);
            $table->string('logradouro');
            $table->string('numero', 20);
            $table->string('complemento', 100)->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->char('estado', 2);
            $table->boolean('principal')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
