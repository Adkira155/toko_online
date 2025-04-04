<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('carts')->insert([     
            [
                'user_id' => 2,
                'produk_id' => 1,
                'quantity' => 2,
                'subtotal_harga' => 25000,
                'subtotal_berat' => 15, 
            ],
            [
                'user_id' => 3,
                'produk_id' => 2,
                'quantity' => 2,
                'subtotal_harga' => 25000,
                'subtotal_berat' => 15, 
            ],
        ]);  
        DB::table('detailorders')->insert([     
            [
                'id_produk' => 1,
                'id_order' => 1,
                'subtotal_harga_item' => 25000,
                'subtotal_berat_item' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);  
        DB::table('orders')->insert([
            [
                'id_user' => 2,
                'total_berat' => 30,
                'total_harga' => 50000,
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
        ]); 
    }
}
