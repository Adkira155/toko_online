<?php

namespace App\Models;

// use App\Livewire\Layout\Produk;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'produk_id',
        'quantity',
        'subtotal_harga',
        'subtotal_berat',
        'is_active',
        'session_id',
    ];


    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}