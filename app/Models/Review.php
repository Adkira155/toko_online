<?php

namespace App\Models;

use App\Livewire\Layout\Produk;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['comment', 'parent_id', 'username', 'produk_id'];
    protected $dates = ['created_at', 'updated_at'];
  
    // public function users()
    // {
    //     return $this->belongsTo(User::class,'id_user');
    // }
    public function produk() 
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

        public function replies()
    {
        return $this->hasMany(Review::class, 'parent_id');
    }

}
