<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    protected $fillable = [
        'user_id',
        'apelido',
        'bandeira',
        'titular',
        'ultimos_digitos',
        'validade',
        'principal',
    ];

    protected $casts = [
        'principal' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getNumeroMascaradoAttribute(): string
    {
        return '•••• •••• •••• ' . $this->ultimos_digitos;
    }
}
