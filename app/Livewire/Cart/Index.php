<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use app\Models\Produk;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Index extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $total = 0;
    public $shipping = 0;

    public function mount()
    {
        $this->loadCartItems();
    }

    public function loadCartItems()
{
    $userId = Auth::id();
    $sessionId = Session::getId();

    try {
        if ($userId) {
            $this->cartItems = Cart::where('user_id', $userId)->with('produk')->get(); // Menggunakan get()
        } else {
            if ($sessionId) {
                $this->cartItems = Cart::where('user_id', 0)->where('session_id', $sessionId)->with('produk')->get(); // Menggunakan get()
            } else {
                $this->cartItems = collect([]); // Menggunakan collect([]) untuk membuat koleksi kosong
            }
        }
    } catch (\Exception $e) {
        Log::error('Error loading cart items: ' . $e->getMessage());
        session()->flash('error', 'Terjadi kesalahan saat memuat keranjang.');
        $this->cartItems = collect([]); // Menggunakan collect([]) untuk membuat koleksi kosong
    }

    $this->calculateTotals();
}


    public function calculateTotals()
    {
        $this->subtotal = 0;
        foreach ($this->cartItems as $item) {
            $this->subtotal += $item->produk->harga * $item->quantity;
        }

        $this->shipping = 2000; // Shipping cost
        $this->total = $this->subtotal + $this->shipping;
    }

    public function updateQuantity($cartId, $action)
    {
        $cartItem = Cart::find($cartId);
        if ($cartItem) {
            if ($action === 'increase') {
                $cartItem->quantity++;
            } elseif ($action === 'decrease' && $cartItem->quantity > 1) {
                $cartItem->quantity--;
            }
            $cartItem->save();
            $this->loadCartItems();
        }
    }

    public function removeFromCart($cartId)
    {
        $cartItem = Cart::find($cartId);
        if ($cartItem) {
            $cartItem->delete();
            $this->loadCartItems();
        }
    }

    public function render()
    {
        return view('livewire.cart.index');
    }
}