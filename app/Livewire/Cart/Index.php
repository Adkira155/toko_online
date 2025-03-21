<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\User;
use App\Models\Produk;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use App\Services\BinderbyteService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Index extends Component
{

    public $snapToken;

    public $cartItems = [];
    public $subtotal = 0;
    public $total = 0;
    public $admin = 2000; // Biaya Admin
    public $ongkir; //Biaya Ongkir

    public $totalHarga = 0; 
    public $totalBerat = 0; 

    public $nomorTelepon;
    public $alamat;
   
    public $namaPenerima;
    public $catatan;
    public $showRingkasan = false;

    public $provinces;
    public $cities;
    public $id_provinsi;
    public $id_kota;

    public $provinsiAsalName;
    public $kotaAsalName;
    public $provinsiAsalId;
    public $kotaAsalId;
    public $courier;

    public $showCheckout = false;
    public $pesanSukses = '';

  
    public function mount()
    {
        $this->loadCartItems();
        
        // Ambil Provinsi dan Kota Admin
        // $this->loadAdminLocation();

        // Ambil Provinsi dan Kota default kaloa admin kdd kota dan provinsi
        $this->loadDefaultLocation();

        $user = Auth::user();
        if ($user) {
            $this->nomorTelepon = $user->nomor;
            $this->alamat = $user->alamat;
        }
        if ($user) {
            $this->namaPenerima = $user->name;
            $this->nomorTelepon = $user->nomor;
            $this->alamat = $user->alamat;
            $this->id_provinsi = $user->id_provinsi;
            $this->id_kota = $user->id_kota;

            $binderbyteService = app(BinderbyteService::class);
            $this->provinces = $binderbyteService->getProvinces();
            // Ambil data kota jika id_provinsi tersedia
            if ($this->id_provinsi) {
                $binderbyteService = app(BinderbyteService::class);
               
              $this->cities = $binderbyteService->getCities($this->id_provinsi); 

            }

        // // Konfigurasi Midtrans
        // Config::$serverKey = config('midtrans.server_key');
        // Config::$isProduction = false;
        // Config::$isSanitized = true;
        // Config::$is3ds = true;

        // // Data transaksi
        // $params = [
        //     'transaction_details' => array(
        //         'order_id' => rand(),
        //         'gross_amount' => 10000,
        //     ),
        //     'customer_details' => array (
        //         'first_name' => 'Juna',
        //         'email' => 'user@gmail.com',
        //         'phone' => '08111222333',
        //     ),
        // ];
        // // Ambil Snap Token
        // $this->snapToken = \Midtrans\Snap::getSnapToken($params);
        // // dd($this->snapToken);
        // return view('livewire.cart.index');
        }
        
    }

    public function loadDefaultLocation()
    {
        $binderbyteService = app(BinderbyteService::class);
        $this->provinces = $binderbyteService->getProvinces();

        // Cari ID provinsi Kalimantan Selatan
        $kalimantanSelatan = collect($this->provinces)->firstWhere('name', 'KALIMANTAN SELATAN');

        if ($kalimantanSelatan) {
            $this->provinsiAsalId = $kalimantanSelatan['id'];
            $this->cities = $binderbyteService->getCities($this->provinsiAsalId);

            // Cari ID kota Banjarmasin
            $banjarmasin = collect($this->cities)->firstWhere('name', 'KOTA BANJARMASIN');

            if ($banjarmasin) {
                $this->id_kota = $banjarmasin['id'];
                $this->kotaAsalId = $banjarmasin['id'];

                // Isi nama provinsi dan kota
                $this->provinsiAsalName = $kalimantanSelatan['name'];
                $this->kotaAsalName = $banjarmasin['name'];
            }
        }
    }
    
    // ambil Kota dan Provinsi asal Admin
    // public function loadAdminLocation()
    // {
    //     $adminUser = User::where('id', 1)->where('role', 'admin')->first();

    //     if ($adminUser) {
    //         $this->id_provinsi = $adminUser->id_provinsi;
    //         $this->id_kota = $adminUser->id_kota;

    //         Log::info('Admin User ID Provinsi: ' . $this->id_provinsi);
    //         Log::info('Admin User ID Kota: ' . $this->id_kota);

    //         $binderbyteService = app(BinderbyteService::class);
    //         $this->provinces = $binderbyteService->getProvinces();
    //         Log::info('Provinces: ' . json_encode($this->provinces));

    //         if ($this->id_provinsi) {
    //             $this->cities = $binderbyteService->getCities($this->id_provinsi);
    //             Log::info('Cities: ' . json_encode($this->cities));

    //             $provinsi = collect($this->provinces)->firstWhere('id', $this->id_provinsi);
    //             $kota = collect($this->cities)->firstWhere('id', $this->id_kota);

    //             Log::info('Provinsi Data: ' . json_encode($provinsi));
    //             Log::info('Kota Data: ' . json_encode($kota));

    //             $this->provinsiAsalName = $provinsi['name'] ?? 'Tidak Diketahui';
    //             $this->kotaAsalName = $kota['name'] ?? 'Tidak Diketahui';
    //         }
    //     }
    // }

       // cart
       public function loadCartItems()
       {
           $userId = Auth::id();
           $sessionId = Session::getId();
   
           try {
               if ($userId) {
                   $this->cartItems = Cart::where('user_id', $userId)->with('produk')->get();
               } else {
                   if ($sessionId) {
                       $this->cartItems = Cart::where('user_id', 0)->where('session_id', $sessionId)->with('produk')->get();
                   } else {
                       $this->cartItems = collect();
                   }
               }
           } catch (\Exception $e) {
               Log::error('Error loading cart items: ' . $e->getMessage());
               session()->flash('error', 'Terjadi kesalahan saat memuat keranjang.');
               $this->cartItems = collect();
           }
   
           $this->calculateTotals();
           $this->hitungTotalHarga(); // Total Harga
           $this->calculateTotalBerat(); // Total Berat
       }

       public function ongkir(){
        $this->ongkir = 50000;
       }
   
        // ngitung subtotal berdasar kuantitas dan harga
        public function calculateTotals()
        {
             $this->subtotal = 0;
             foreach ($this->cartItems as $item) {
                 $this->subtotal += $item->produk->harga * $item->quantity;
             }
     
             $this->total = $this->subtotal + $this->admin;
        }

       // hitung Berat total
       public function calculateTotalBerat()
       {
           $this->totalBerat = 0;
           foreach ($this->cartItems as $item) {
               // Pastikan produk memiliki atribut berat
               if (isset($item->produk->berat)) {
                   $this->totalBerat += $item->produk->berat * $item->quantity;
               }
           }
       }

        // Total harga
       public function hitungTotalHarga()
        {
            $this->totalHarga = $this->subtotal + $this->admin + $this->ongkir;
        }

       public function incrementQuantity($cartId)
       {
           $this->updateQuantity($cartId, 'increase');
       }
   
       public function decrementQuantity($cartId)
       {
           $this->updateQuantity($cartId, 'decrease');
       }
   
       // perbarui kuantitas
       public function updateQuantity($cartId, $action)
       {
           $cartItem = Cart::find($cartId);
           if ($cartItem) {
               $produk = $cartItem->produk;
               if ($action === 'increase') {
                   if ($cartItem->quantity < $produk->stok) { // Cek stok sebelum menambah
                       $cartItem->quantity++;
                   } else {
                       session()->flash('error', 'Stok tidak mencukupi.');
                   }
               } elseif ($action === 'decrease' && $cartItem->quantity > 1) {
                   $cartItem->quantity--;
               }
               $cartItem->save();
        
               $this->loadCartItems();
               $this->hitungTotalHarga();
           }
       }
   
       // hapus keranjang data
       public function removeItem($cartId)
       {
           $cartItem = Cart::find($cartId);
           if ($cartItem) {
               $cartItem->delete();
            
               $this->loadCartItems();
               $this->hitungTotalHarga(); 
           }
       }
       
    // rincian
    public function submitData()
    {
        // Validasi data
        $this->validate([
            'namaPenerima' => 'required',
            'catatan' => 'nullable',
            'courier' => 'required',
        ]);

        $this->showRingkasan = true;
        $this->ongkir();
        $this->hitungTotalHarga();
    }

    // checkout form 
    public function showCheckoutForm()
    {
        $this->showCheckout = true;
    }

      // render
    public function render()
    {
        return view('livewire.cart.index');
    }

    public function checkout()
    {
        $this->pesanSukses = 'Tombol Checkout ditekan!';
    }

}
