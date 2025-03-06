<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produks')->insert([
            [
                'nama_produk' => 'Produk 1',
                'harga' => 250000,
                'deskripsi' => 'Deskripsi produk',
                'stok' => 15,
                'image' => 'https://plus.unsplash.com/premium_photo-1682124445940-1c248d19ad0b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);            
    }
}
