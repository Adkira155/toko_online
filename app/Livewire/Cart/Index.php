<?php

namespace App\Livewire\Cart;

use Exception;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Cart;
use App\Models\Order;
use Livewire\Component;
use App\Models\Orderdetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\BinderbyteService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
    public $loading;

    public function __construct()
    {
        try {
            $serverKey = config('midtrans.server_key');

            if (empty($serverKey)) {
                throw new Exception('Midtrans server key is not configured. Please check your .env file');
            }

            Config::$serverKey = $serverKey;
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.sanitize');
            Config::$is3ds = config('midtrans.enable_3ds');

            Log::info('Midtrans Configuration Loaded', [
                'isProduction' => Config::$isProduction,
                'isSanitized' => Config::$isSanitized,
                'is3ds' => Config::$is3ds
            ]);
        } catch (Exception $e) {
            Log::error('Midtrans configuration error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function checkout()
    {
        // Validasi data
        $this->validate([
            'namaPenerima' => 'required',
            'nomorTelepon' => 'required',
            'alamat' => 'required',
            'courier' => 'required',
            'catatan' => 'nullable',
        ]);

        // Cek ID user
        $userId = Auth::id();
        $carts = Cart::where('user_id', $userId)->get();

        // Kondisi jika keranjang kosong
        if ($carts->isEmpty()) {
            session()->flash('error', 'Keranjang Anda kosong.');
            return;
        }

        // Ubah status keranjang menjadi 'checkout'
        foreach ($carts as $cart) {
            $this->updateStatus($cart->id, 'checkout');
        }

        // Ambil item keranjang dengan status 'checkout'
        $cartsCheckout = Cart::where('user_id', $userId)->where('status', 'checkout')->with('produk')->get();

        // Kondisi jika tidak ada item 'checkout' di keranjang
        if ($cartsCheckout->isEmpty()) {
            session()->flash('error', 'Tidak ada item yang di-checkout.');
            return;
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Buat pesanan terlebih dahulu
            $order = Order::create([
                'id_user' => $userId,
                'total_harga' => $this->totalHarga,
                'total_berat' => $this->totalBerat,
                'nama_penerima' => $this->namaPenerima,
                'nomor_telepon' => $this->nomorTelepon,
                'id_provinsi' => $this->id_provinsi,
                'id_kota' => $this->id_kota,
                'alamat' => $this->alamat,
                'courier' => $this->courier,
                'catatan' => $this->catatan,
                'status' => 'pending',
                'ongkir' => $this->ongkir,
                'invoice' => 'INV-' . Str::random(10), // Generate invoice number
            ]);

            $items = [];

            // Loop melalui setiap item di keranjang yang di-checkout
            foreach ($cartsCheckout as $cart) {
                $produk = $cart->produk;

                // Periksa stok sebelum membuat detail pesanan
                if ($produk->stok >= $cart->quantity) {
                    // Buat detail pesanan
                    Orderdetail::create([
                        'id_order' => $order->id,
                        'id_produk' => $produk->id,
                        'quantity' => $cart->quantity,
                        'subtotal_harga_item' => $produk->harga * $cart->quantity,
                        'subtotal_berat_item' => $produk->berat * $cart->quantity,
                    ]);

                    // Kurangi stok produk
                    $produk->stok -= $cart->quantity;
                    $produk->save();

                    $items[] = [
                        'id' => (string) $produk->id,
                        'price' => (int) $produk->harga,
                        'quantity' => (int) $cart->quantity,
                        'name' => $produk->nama_produk,
                    ];

                    // Hapus item dari keranjang
                    $cart->delete();
                } else {
                    session()->flash('error', 'Stok ' . $produk->nama_produk . ' tidak mencukupi.');
                    throw new \Exception('Stok tidak mencukupi.');
                }
            }

            // Tambahkan ongkos kirim ke daftar item
            $items[] = [
                'id' => 'shipping',
                'price' => (int) $this->ongkir,
                'quantity' => 1,
                'name' => 'Shipping Cost'
            ];
            $admins[] = [
                'id' => 'admin',
                'price' => (int) $this->admin,
                'quantity' => 1,
                'name' => 'Biaya Admin'
            ];

            // Generate Midtrans Snap Token
            $this->snapToken = $this->generateSnapToken($order, $items, $admins);
            

            // Commit transaksi database
            DB::commit();

            // Set pesan sukses dan sembunyikan form
            $this->showCheckout = false;
            $this->showRingkasan = false;

            // Redirect ke halaman pembayaran atau tampilkan modal Midtrans
            return redirect()->to("https://app.sandbox.midtrans.com/snap/v2/vtweb/" . $this->snapToken);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();

            // Tangani error
            session()->flash('error', 'Terjadi kesalahan saat memproses checkout. Silakan coba lagi.');
            Log::error('Checkout error: ' . $e->getMessage());

            // Set loading
            $this->loading = false;
            return;
        }
    }

    private function generateSnapToken(Order $order, $items)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->invoice,
                'gross_amount' => $this->totalHarga + $this->ongkir + $this->admin,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $this->namaPenerima,
                'phone' => $this->nomorTelepon,
                'address' => $this->alamat,
                'email' => Auth::user()->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token error: ' . $e->getMessage());
            session()->flash('error', 'Gagal membuat token pembayaran. Silakan coba lagi.');
            return null;
        }
    }

    // public function checkout()
    // {
    //     // Validasi data
    //     $this->validate([
    //         'namaPenerima' => 'required',
    //         'nomorTelepon' => 'required',
    //         'alamat' => 'required',
    //         'courier' => 'required',
    //         'catatan' => 'nullable',
    //     ]);

    //     // Cek ID user
    //     $userId = Auth::id();
    //     $carts = Cart::where('user_id', $userId)->get();

    //     // Kondisi jika keranjang kosong
    //     if ($carts->isEmpty()) {
    //         session()->flash('error', 'Keranjang Anda kosong.');
    //         return;
    //     }

    //     // Ubah status keranjang menjadi 'checkout'
    //     foreach ($carts as $cart) {
    //         $this->updateStatus($cart->id, 'checkout');
    //     }

    //     // Ambil item keranjang dengan status 'checkout'
    //     $cartsCheckout = Cart::where('user_id', $userId)->where('status', 'checkout')->with('produk')->get();

    //     // Kondisi jika tidak ada item 'checkout' di keranjang
    //     if ($cartsCheckout->isEmpty()) {
    //         session()->flash('error', 'Tidak ada item yang di-checkout.');
    //         return;
    //     }

    //     // Mulai transaksi database
    //     DB::beginTransaction();

    //     try {
    //         // Buat pesanan terlebih dahulu
    //         $order = Order::create([
    //             'id_user' => $userId,
    //             'total_harga' => $this->totalHarga,
    //             'total_berat' => $this->totalBerat,
    //             'nama_penerima' => $this->namaPenerima,
    //             'nomor_telepon' => $this->nomorTelepon,
    //             'id_provinsi' => $this->id_provinsi,
    //             'id_kota' => $this->id_kota,
    //             'alamat' => $this->alamat,
    //             'courier' => $this->courier,
    //             'catatan' => $this->catatan,
    //             'status' => 'pending',
    //             'ongkir' => $this->ongkir,
    //             'invoice' => 'INV-' . Str::random(10), // Generate invoice number
    //         ]);

    //         // Loop melalui setiap item di keranjang yang di-checkout
    //         foreach ($cartsCheckout as $cart) {
    //             $produk = $cart->produk;

    //             // Periksa stok sebelum membuat detail pesanan
    //             if ($produk->stok >= $cart->quantity) {
    //                 // Buat detail pesanan
    //                 Orderdetail::create([
    //                     'id_order' => $order->id,
    //                     'id_produk' => $produk->id,
    //                     'quantity' => $cart->quantity,
    //                     'subtotal_harga_item' => $produk->harga * $cart->quantity,
    //                     'subtotal_berat_item' => $produk->berat * $cart->quantity,
    //                 ]);

    //                 // Kurangi stok produk
    //                 $produk->stok -= $cart->quantity;
    //                 $produk->save();

    //                 // Hapus item dari keranjang
    //                 $cart->delete();
    //             } else {
    //                 session()->flash('error', 'Stok ' . $produk->nama_produk . ' tidak mencukupi.');
    //                 throw new \Exception('Stok tidak mencukupi.');
    //             }
    //         }

    //         // Generate Midtrans Snap Token
    //         $this->snapToken = $this->generateSnapToken($order);

    //         // Commit transaksi database
    //         DB::commit();

    //         // Set pesan sukses dan sembunyikan form
    //         $this->pesanSukses = 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.';
    //         $this->showCheckout = false;
    //         $this->showRingkasan = false;

    //         // Redirect ke halaman pembayaran atau tampilkan modal Midtrans
    //         $this->dispatchBrowserEvent('show-midtrans-modal', ['snapToken' => $this->snapToken]);
    //     } catch (\Exception $e) {
    //         // Rollback transaksi jika terjadi error
    //         DB::rollback();

    //         // Tangani error
    //         session()->flash('error', 'Terjadi kesalahan saat memproses checkout. Silakan coba lagi.');
    //         Log::error('Checkout error: ' . $e->getMessage());

    //         // Set loading
    //         $this->loading = false;
    //         return;
    //     }
    // }

    // private function generateSnapToken(Order $order)
    // {
    //     $params = [
    //         'transaction_details' => [
    //             'order_id' => $order->invoice,
    //             'gross_amount' => $this->totalHarga,
    //         ],
    //         'customer_details' => [
    //             'first_name' => $this->namaPenerima,
    //             'phone' => $this->nomorTelepon,
    //             'address' => $this->alamat,
    //         ],
    //     ];

    //     try {
    //         $snapToken = Snap::getSnapToken($params);
    //         $order->update(['snap_token' => $snapToken]);
    //         return $snapToken;
    //     } catch (\Exception $e) {
    //         Log::error('Midtrans Snap Token error: ' . $e->getMessage());
    //         session()->flash('error', 'Gagal membuat token pembayaran. Silakan coba lagi.');
    //         return null;
    //     }
    // }
  
    public function mount()
    {
        $this->loadCartItems();
        
        // Ambil Provinsi dan Kota Admin
        // $this->loadAdminLocation();

        // Ambil Provinsi dan Kota default kalonya admin kdd kota dan provinsi
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

    // update Status 
        public function updateStatus($cartId, $status)
    {
        $cartItem = Cart::find($cartId);
        
        if ($cartItem) {
            $cartItem->status = $status; // Update status
            $cartItem->save();

            $this->loadCartItems(); // Reload keranjang setelah update status
        }
    }

    // public function checkout()
    // {
    //     // Validasi data
    //     $this->validate([
    //         'namaPenerima' => 'required',
    //         'nomorTelepon' => 'required',
    //         'alamat' => 'required',
    //         'courier' => 'required',
    //         'catatan' => 'nullable',
    //     ]);

    //     // Cek ID user
    //     $userId = Auth::id();
    //     $carts = Cart::where('user_id', $userId)->get();

    //     // Kondisi jika keranjang kosong
    //     if ($carts->isEmpty()) {
    //         session()->flash('error', 'Keranjang Anda kosong.');
    //         return;
    //     }

    //     // Ubah status keranjang menjadi 'checkout'
    //     foreach ($carts as $cart) {
    //         $this->updateStatus($cart->id, 'checkout');
    //     }

    //     // Ambil item keranjang dengan status 'checkout'
    //     $cartsCheckout = Cart::where('user_id', $userId)->where('status', 'checkout')->with('produk')->get();

    //     // Kondisi jika tidak ada item 'checkout' di keranjang
    //     if ($cartsCheckout->isEmpty()) {
    //         session()->flash('error', 'Tidak ada item yang di-checkout.');
    //         return;
    //     }

    //     // Mulai transaksi database
    //     DB::beginTransaction();

    //     try {
    //         // Buat pesanan terlebih dahulu
    //         $order = \App\Models\Order::create([
    //             'id_user' => $userId,
    //             'total_harga' => $this->totalHarga,
    //             'total_berat' => $this->totalBerat,
    //             'nama_penerima' => $this->namaPenerima,
    //             'nomor_telepon' => $this->nomorTelepon,
    //             'id_provinsi' => $this->id_provinsi,
    //             'id_kota' => $this->id_kota,
    //             'alamat' => $this->alamat,
    //             'courier' => $this->courier,
    //             'catatan' => $this->catatan,
    //             'status' => 'pending',
    //             'ongkir' => $this->ongkir,
    //         ]);

    //         // Loop melalui setiap item di keranjang yang di-checkout
    //         foreach ($cartsCheckout as $cart) {
    //             $produk = $cart->produk;

    //             // Periksa stok sebelum membuat detail pesanan
    //             if ($produk->stok >= $cart->quantity) {
    //                 // Buat detail pesanan
    //                 $orderDetail = \App\Models\OrderDetail::create([
    //                     'id_order' => $order->id,
    //                     'id_produk' => $produk->id,
    //                     'quantity' => $cart->quantity,
    //                     'subtotal_harga_item' => $produk->harga * $cart->quantity,
    //                     'subtotal_berat_item' => $produk->berat * $cart->quantity,
    //                 ]);

    //                 // Kurangi stok produk
    //                 $produk->stok -= $cart->quantity;
    //                 $produk->save();

    //                 // Hapus item dari keranjang
    //                 $cart->delete();

    //             } else {
    //                 session()->flash('error', 'Stok ' . $produk->nama_produk . ' tidak mencukupi.');
    //                 throw new \Exception('Stok tidak mencukupi.');
    //             }
    //         }

    //         DB::commit();

    //         $this->pesanSukses = 'Pesanan berhasil dibuat!';
    //         $this->loadCartItems(); // Muat ulang keranjang setelah checkout
    //         $this->showCheckout = false; // Sembunyikan form checkout
    //         $this->showRingkasan = false; // Sembunyikan ringkasan

    //     } catch (\Exception $e) {
    //         // Tangani error
    //         session()->flash('error', 'Terjadi kesalahan saat memproses checkout. Silakan coba lagi.');

    //         // Set loading
    //         $this->loading = false;
    //         return;
    //     }
    // }

}