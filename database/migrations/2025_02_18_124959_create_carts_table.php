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
        if (!Schema::hasTable('carts')) {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->cascadeOnDelete();
            $table->integer('produk_id')->cascadeOnDelete();
            $table->integer('quantity');
            $table->integer('subtotal_harga');
            $table->integer('subtotal_berat');
            $table->enum('status', [
                'keranjang', 'checkout'
            ])->default('keranjang');
            $table->string('session_id')->nullable();
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
