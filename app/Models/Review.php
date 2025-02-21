<?php

namespace App\Models;

use App\Livewire\Layout\Produk;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['review', 'reply', 'user_id', 'product_id'];
  
    public function users()
    {
        return $this->belongsTo(User::class,'id_user');
    }
    public function produks()
    {
        return $this->belongsTo(Produk::class,'id_produk');
    }

}
