<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';
    protected $guarded = ['id'];
    protected $fillable = [
        'nama_produk',
        'slug',
        'id_kategori',
        'deskripsi',
        'harga',
        'berat',
        'stok',
        'image',
        'status',
    ];

    // Cart
    public function carts()
    {
        return $this->hasMany(Cart::class, 'produk_id');
    }

    // Kategori
    public function kategoris()
    {
        return $this->belongsTo(Kategori::class,'id_kategori');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_produk');
    }
}