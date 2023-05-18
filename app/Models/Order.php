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
        'order_id',
        'payment_code',
        'payment_type',
        'status',
        'transaction_id',
        'invoice_url',
        'total_amount',
        'snap_token'
    ];

    /**
     * Get all of the comments for the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function item(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function addSnapToken($snap_token)
    {
        if ($this->snap_token == null) {
            $this->update([
                'snap_token' => $snap_token
            ]);
        }
    }

    public function getTotalAmount()
    {
        $total = 0;
        foreach ($this->item as $value) {
           $total += ($value['price'] * $value['qty']);
        }
        return number_format($total, 2, '.', '');;
    }
}
