<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = ['id'];

    public function orderdetail(): HasOne
    {
        return $this->hasOne(Orderdetail::class, 'id_order');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function produk()
    {
        return $this->hasOneThrough(
            Produk::class,
            Orderdetail::class,
            'id_order',
            'id',
            'id',
            'id_produk'
        );
    }
}