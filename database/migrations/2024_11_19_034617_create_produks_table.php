<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->string('slug')->unique()->nullable();
            $table->foreignId('id_kategori');
            $table->text('deskripsi');
            $table->decimal('harga', 15, 2);
            $table->decimal('berat', 10, 2)->nullable();            
            $table->integer('stok');
            $table->string('image');
            $table->string('status')->default('aktif'); // Status sebagai string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
