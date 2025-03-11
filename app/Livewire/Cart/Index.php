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
    public $nama_kota;

    public $showCheckout = false;

    public function mount()
    {
        $this->loadCartItems();

        // Ambil Provinsi dan Kota Admin
        // belum ada fungsinya


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

    // render
    public function render()
    {
        return view('livewire.cart.index');
    }

    // 
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

    // checkout form 
    public function showCheckoutForm()
    {
        $this->showCheckout = true;
    }

    public function submitData()
    {
        // Validasi data jika diperlukan
        $this->validate([
            'namaPenerima' => 'required',
            'catatan' => 'nullable',
        ]);

        $this->showRingkasan = true;
    }

}
