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
                'nama_produk' => 'Wooden Chair',
                'harga' => 250000,
                'deskripsi' => 'A beautifully crafted wooden chair for your living room.',
                'stok' => 15,
                'image' => 'https://plus.unsplash.com/premium_photo-1682124445940-1c248d19ad0b?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Modern Lamp',
                'harga' => 120000,
                'deskripsi' => 'A stylish modern lamp that brightens your room.',
                'stok' => 25,
                'image' => 'https://images.unsplash.com/photo-1648134859196-3aa762e9440d?q=80&w=1460&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Cozy Sofa',
                'harga' => 800000,
                'deskripsi' => 'A cozy and comfortable sofa for your living space.',
                'stok' => 8,
                'image' => 'https://images.unsplash.com/photo-1558137623-ce933996c730?q=80&w=1406&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'status' => 'aktif',
                'id_kategori' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Vintage Table',
                'harga' => 400000,
                'deskripsi' => 'A vintage-style table to add charm to your room.',
                'stok' => 10,
                'image' => 'https://images.unsplash.com/photo-1570155308259-f4480a5c3696?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cm9ib3QlMjBpb3R8ZW58MHx8MHx8fDA%3D',
                'status' => 'aktif',
                'id_kategori' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Bookshelf',
                'harga' => 300000,
                'deskripsi' => 'A compact bookshelf to organize your books and decor.',
                'stok' => 20,
                'image' => 'https://media.istockphoto.com/id/1339547170/photo/robotic-arms-technology-background.webp?a=1&b=1&s=612x612&w=0&k=20&c=zdWPNbwXyyvmgbL9Zesdh5PmTlH76qLnGsjQSN8Hjto=',
                'status' => 'aktif',
                'id_kategori' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Wall Art',
                'harga' => 150000,
                'deskripsi' => 'A beautiful piece of wall art to enhance your decor.',
                'stok' => 30,
                'image' => 'https://images.unsplash.com/file-1720553250263-3b4f25a93c9cimage?w=416&dpr=2&auto=format&fit=crop&q=60',
                'status' => 'aktif',
                'id_kategori' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);            
    }
}
