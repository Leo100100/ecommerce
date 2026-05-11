<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'observacoes',
        'endereco_entrega',
        'data_entrega_prevista',
        'pagamento_titular',
        'pagamento_bandeira',
        'pagamento_ultimos_digitos',
        'pagamento_validade',
        'frete_valor',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }
    public function recalcularTotal()
    {
        $total = $this->items->sum(function ($item) {
            return $item->preco * $item->quantidade;
        });

        $this->update(['total' => $total]);
    }
    public function history()
    {
        return $this->hasMany(OrderStatusHistory::class)
            ->orderBy('created_at', 'asc');
    }
}
