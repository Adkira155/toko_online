<?php

namespace App\Livewire\Cart;

use Midtrans\Config;
use App\Models\Order;
use Livewire\Component;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class Summary extends Component
{
    public $snapToken;

     // Konfigurasi Midtrans

     public function mount() {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data transaksi
        $params = [
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array (
                'first_name' => 'Juna',
                'email' => 'user@gmail.com',
                'phone' => '08111222333',
            ),
        ];
        // Ambil Snap Token
        $this->snapToken = \Midtrans\Snap::getSnapToken($params);
        // dd($this->snapToken);
        return view('livewire.cart.index');

     }
       

    public function render()
    {
        return view('livewire.cart.checkout');
    }

    
}
