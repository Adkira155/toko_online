<?php

namespace App\Models;

use App\Livewire\Layout\Produk;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $guarded = ['id'];

    public function produks(){
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
