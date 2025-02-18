<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $table = 'produks';
    protected $guarded = ['id'];

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class,'id_kategori');
    }

}
