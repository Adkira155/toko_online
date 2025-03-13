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
               $table->foreignId('id_detailorder');

                $table->decimal('total_weight', 15, 2);
                $table->decimal('total_price', 15, 2);

                $table->enum('status', [
                    'pending', 'processing', 'shipped', 'delivered', 'Completed', 'cancelled'
                ])->default('pending');

                $table->string('nama_penerima')->nullable();
                $table->string('catatan')->nullable();
                
                $table->string('metode_pembayaran')->nullable();
                $table->integer('ongkir')->nullable();
                $table->text('shipping_address')->nullable();
                $table->string('alamat_detail')->nullable();

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
