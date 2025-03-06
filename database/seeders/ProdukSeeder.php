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
                'berat' => 15,
                'image' => 'img/akira.png',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_produk' => 'Produk 2',
                'harga' => 250000,
                'deskripsi' => 'Deskripsi produk',
                'stok' => 15,
                'berat' => 15,
                'image' => 'img/zuyya.png',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Produk 3',
                'harga' => 250000,
                'deskripsi' => 'Deskripsi produk',
                'stok' => 15,
                'berat' => 15,
                'image' => 'img/tya.png',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);            
    }
}
