<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasUuids;

    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_method',
        'amount',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
