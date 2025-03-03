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
        ]);  
        DB::table('orders')->insert([
            [
                'id_user' => 2,
                'id_detailorder' => 1,
                'total_weight' => 30,
                'total_price' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
        ]);  
        DB::table('detailorders')->insert([     
            [
                'id_produk' => 1,
                'subtotal_harga_item' => 25000,
                'subtotal_berat_item' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);  
    }
}
