<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'apelido',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'principal',
    ];

    protected $casts = [
        'principal' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enderecoCompleto(): string
    {
        $end = "{$this->logradouro}, {$this->numero}";
        if ($this->complemento) $end .= " — {$this->complemento}";
        $end .= " · {$this->bairro} · {$this->cidade}/{$this->estado} · CEP {$this->cep}";
        return $end;
    }
}
