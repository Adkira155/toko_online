<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'alamat',
        'role',
        'nomor',
        'email',
        'password',
        'social_id',
        'social_type',
        'id_provinsi',
        'id_kota',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function carts($produk_id){
        return $this->hasMany(Cart::class)->where('produk_id', $produk_id)->first();
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'id_order');
    }
    // public function reviews()
    // {
    //     return $this->hasMany(Review::class,'id_review');
    // }

}
