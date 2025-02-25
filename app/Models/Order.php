<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = ['id'];

    public function detailorders()
    {
        return $this->hasMany(Orderdetail::class,'id_detailorder');
    }
}
