<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $total = 0;
    public $shipping = 2000; // Biaya pengiriman

    public function mount()
    {
        $this->loadCartItems();
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
}
