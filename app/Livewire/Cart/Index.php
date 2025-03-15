<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use App\Models\User;
use App\Models\Produk;
use Livewire\Component;
use App\Services\BinderbyteService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $total = 0;
    public $admin = 2000; // Biaya pengiriman

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

    public $showCheckout = false;

    public $ongkosKirim = 0;
    public $totalHargaDenganOngkir = 0;
    public $courier;

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
        }
        // dd($this->all());
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
           $this->calculateTotalBerat(); // Hitung total berat setelah memuat item
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
   
       // ngitung subtotal berdasar kuantitas dan harga
       public function calculateTotals()
       {
           $this->subtotal = 0;
           foreach ($this->cartItems as $item) {
               $this->subtotal += $item->produk->harga * $item->quantity;
           }
   
           $this->total = $this->subtotal + $this->admin;
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
           }
       }

    //    public function hitungOngkosKirim()
    //    {
    //        $binderbyteService = app(BinderbyteService::class);
       
    //        // Pastikan semua data yang dibutuhkan tersedia
    //        if (empty($this->id_kota) || empty($this->kotaAsalId)) {
    //            session()->flash('error', 'Provinsi, kota tujuan, atau kota asal tidak valid.');
    //            Log::error('Provinsi, kota tujuan, atau kota asal tidak valid.');
    //            return;
    //        }
       
    //        // Validasi berat
    //        if (!is_numeric($this->totalBerat) || $this->totalBerat <= 0) {
    //            session()->flash('error', 'Berat barang tidak valid.');
    //            Log::error('Total berat tidak valid: ' . $this->totalBerat);
    //            return;
    //        }
       
    //        // Validasi courier
    //        if (empty($this->courier)) {
    //            session()->flash('error', 'Kurir harus dipilih.');
    //            Log::error('Kurir tidak dipilih.');
    //            return;
    //        }
       
    //        // Log informasi sebelum API call
    //        Log::info('Menghitung ongkos kirim: Asal=' . $this->kotaAsalId . ', Tujuan=' . $this->id_kota . ', Berat=' . $this->totalBerat . ', Courier=' . $this->courier);
       
    //        // Panggil API cek ongkir
    //        $this->ongkosKirim = $binderbyteService->cekOngkir(
    //            $this->kotaAsalId,  // Kota asal dari admin/default
    //            $this->id_kota,     // Kota tujuan dari user
    //            $this->totalBerat,  // Berat total produk di keranjang
    //            $this->courier      // Kurir yang dipilih
    //        );
       
    //        // Pastikan ongkos kirim valid
    //        if ($this->ongkosKirim !== null && is_numeric($this->ongkosKirim)) {
    //            $this->totalHargaDenganOngkir = $this->total + $this->ongkosKirim;
    //            Log::info('Ongkos kirim berhasil dihitung: ' . $this->ongkosKirim);
    //        } else {
    //            session()->flash('error', 'Gagal menghitung ongkos kirim.');
    //            Log::error('Gagal menghitung ongkos kirim.');
    //        }
    //    }

    public function hitungOngkosKirim()
    {
        $binderbyteService = app(BinderbyteService::class);
    
        if (empty($this->id_kota) || empty($this->kotaAsalId)) {
            session()->flash('error', 'Provinsi, kota tujuan, atau kota asal tidak valid.');
            Log::error('Provinsi, kota tujuan, atau kota asal tidak valid.');
            return;
        }
    
        if (!is_numeric($this->totalBerat) || $this->totalBerat <= 0) {
            session()->flash('error', 'Berat barang tidak valid.');
            Log::error('Total berat tidak valid: ' . $this->totalBerat);
            return;
        }
    
        if (empty($this->courier)) {
            session()->flash('error', 'Kurir harus dipilih.');
            Log::error('Kurir tidak dipilih.');
            return;
        }
    
        Log::info("Menghitung ongkos kirim: Asal={$this->kotaAsalId}, Tujuan={$this->id_kota}, Berat={$this->totalBerat}, Courier={$this->courier}");
    
        try {
            $response = $binderbyteService->cekOngkir(
                $this->kotaAsalId,
                $this->id_kota,
                $this->totalBerat,
                $this->courier
            );
    
            if (!empty($response) && isset($response[0]['costs'][0]['cost'][0]['value'])) {
                $this->ongkosKirim = $response[0]['costs'][0]['cost'][0]['value'];
                $this->hitungTotalHarga(); // Perbarui total harga dengan ongkir
                Log::info('Ongkos kirim berhasil dihitung: ' . $this->ongkosKirim);
            } else {
                throw new \Exception('Response API tidak valid');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghitung ongkos kirim.');
            Log::error('Gagal menghitung ongkos kirim: ' . $e->getMessage());
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
        $this->hitungOngkosKirim(); // Hitung ongkos kirim
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
        return redirect()->route('checkout');
    }
}
