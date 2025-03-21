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
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_user');
               $table->foreignId('id_detailorder')->nullable();

               $table->integer('total_berat')->nullable();
               $table->decimal('total_harga', 15, 2)->nullable();

               $table->enum('status', [
                   'pending', 'paid', 'processing', 'shipped', 'delivered', 'completed', 'cancelled'
               ])->default('pending');


               $table->string('nama_penerima')->nullable();
               $table->string('nomor_telepon')->nullable();
               $table->string('catatan')->nullable();

               $table->string('courier')->nullable();
               $table->decimal('ongkir', 15, 2)->nullable();

               $table->integer('id_provinsi')->nullable();
               $table->integer('id_kota')->nullable();

               $table->string('metode_pembayaran')->nullable();
               $table->string('midtrans_transaction_id')->nullable();
               $table->string('midtrans_payment_type')->nullable();
               $table->string('snap_token')->nullable();
               $table->string('resi_code')->nullable();
               $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
