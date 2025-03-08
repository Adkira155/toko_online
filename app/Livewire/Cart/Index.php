<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use App\Models\Produk;
use Livewire\Component;
use App\Services\BinderbyteService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $total = 0;
    public $shipping = 2000; // Biaya pengiriman

    public $namaPenerima;
    public $nomorTelepon;
    public $alamat;
    public $catatan;
    public $provinces;
    public $cities;
    public $id_provinsi;
    public $id_kota;
    public $nama_kota;

    public function mount()
    {
        $this->loadCartItems();

        $user = Auth::user();
        if ($user) {
            $this->namaPenerima = $user->name;
            $this->nomorTelepon = $user->nomor;
            $this->alamat = $user->alamat;
            $this->id_provinsi = $user->id_provinsi;
            $this->id_kota = $user->id_kota;
            $this->nama_kota = $user->nama_kota;

            $binderbyteService = app(BinderbyteService::class);
            $this->provinces = $binderbyteService->getProvinces();
            // Ambil data kota jika id_provinsi tersedia
            if ($this->id_provinsi) {
                $binderbyteService = app(BinderbyteService::class);
               
              $this->cities = $binderbyteService->getCities($this->id_provinsi);
            }
        }
    }


    public function render()
    {
        return view('livewire.cart.index');
    }

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
                    $this->cartItems = collect([]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error loading cart items: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat memuat keranjang.');
            $this->cartItems = collect([]);
        }

        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        foreach ($this->cartItems as $item) {
            $this->subtotal += $item->produk->harga * $item->quantity;
        }

        $this->total = $this->subtotal + $this->shipping;
    }

    public function incrementQuantity($cartId)
    {
        $this->updateQuantity($cartId, 'increase');
    }

    public function decrementQuantity($cartId)
    {
        $this->updateQuantity($cartId, 'decrease');
    }

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

    public function removeItem($cartId)
    {
        $cartItem = Cart::find($cartId);
        if ($cartItem) {
            $cartItem->delete();
            $this->loadCartItems();
        }
    }

    public $showCheckout = false;

    public function showCheckoutForm()
    {
        $this->showCheckout = true;
    }

}
