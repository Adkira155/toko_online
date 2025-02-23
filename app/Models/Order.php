<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->hasMany(Order::class,'id_order');
    }
}
