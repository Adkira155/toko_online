<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $guarded = ['id'];

    public function produks()
    {
        return $this->hasMany(produk::class, 'id_kategori');
    }
}
