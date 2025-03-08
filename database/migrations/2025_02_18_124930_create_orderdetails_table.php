<?php

use App\Models\Produk;
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
        if (!Schema::hasTable('detailorders')) {
        Schema::create('detailorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produk');
            $table->foreignId('id_order');
            $table->integer('subtotal_harga_item');
            $table->integer('subtotal_berat_item');
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderdetails');
    }
};
