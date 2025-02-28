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

            [
                'nama_produk' => 'Produk 2',
                'harga' => 250000,
                'deskripsi' => 'Deskripsi produk',
                'stok' => 15,
                'image' => 'https://plus.unsplash.com/premium_photo-1682124445940-1c248d19ad0b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_produk' => 'produk 3',
                'harga' => 250000,
                'deskripsi' => 'Deskripsi produk',
                'stok' => 15,
                'image' => 'https://plus.unsplash.com/premium_photo-1682124445940-1c248d19ad0b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_produk' => 'Produk 4',
                'harga' => 250000,
                'deskripsi' => 'Deskripsi produk',
                'stok' => 15,
                'image' => 'https://plus.unsplash.com/premium_photo-1682124445940-1c248d19ad0b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_produk' => 'Produk 5',
                'harga' => 250000,
                'deskripsi' => 'Deskripsi produk',
                'stok' => 15,
                'image' => 'https://plus.unsplash.com/premium_photo-1682124445940-1c248d19ad0b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_produk' => 'Produk 6',
                'harga' => 250000,
                'deskripsi' => 'Deskripsi produk',
                'stok' => 15,
                'image' => 'https://plus.unsplash.com/premium_photo-1682124445940-1c248d19ad0b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_produk' => 'Produk 7',
                'harga' => 250000,
                'deskripsi' => 'Deskripsi produk',
                'stok' => 15,
                'image' => 'https://plus.unsplash.com/premium_photo-1682124445940-1c248d19ad0b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_produk' => 'Produk 8',
                'harga' => 250000,
                'deskripsi' => 'Deskripsi produk',
                'stok' => 15,
                'image' => 'https://plus.unsplash.com/premium_photo-1682124445940-1c248d19ad0b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_produk' => 'Produk 9',
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
