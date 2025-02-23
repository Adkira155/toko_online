<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    protected $table = 'orderdetails';
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->belongsTo(Order::class,'id_order');
    }
}
