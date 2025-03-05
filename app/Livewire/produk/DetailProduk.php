<?php

namespace App\Livewire\Produk;

use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class DetailProduk extends Component
{
    public $id;
    public $data;
    public $quantityCount = 1;

    public function mount($id): void
    {
        $this->id = $id;
        $this->data = Produk::findOrFail($id);
    }

    public function addToCart($product_id)
    {
        $product = Produk::find($product_id);

        if (!$product || $product->status != 'aktif') {
            return abort(404);
        }

        if ($product->stok <= 0) {
            session()->flash('toast-error', 'Out of stock');
            return false;
        }

        if ($product->stok < $this->quantityCount) {
            session()->flash('toast-error', 'Only ' . $product->stok . ' Quantity Available');
            return false;
        }

        $subtotalHarga = $product->harga * $this->quantityCount;
        $subtotalBerat = $product->berat * $this->quantityCount;

        if (Auth::check()) {
            if (Cart::where('user_id', Auth::id())->where('produk_id', $product_id)->exists()) {
                session()->flash('toast-message', 'Product Already Added to cart');
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'produk_id' => $product_id,
                    'quantity' => $this->quantityCount,
                    'subtotal_harga' => $subtotalHarga,
                    'subtotal_berat' => $subtotalBerat,
                ]);

                $this->dispatch('cartUpdated');
                session()->flash('toast-message', 'Product Added to cart');
            }
        } else {
            // Gunakan user_id 0 untuk pengguna tamu
            $sessionId = Session::getId();
            $existingCart = Cart::where('user_id', 0)
                ->where('produk_id', $product_id)
                ->where('session_id', $sessionId)
                ->exists();

            if ($existingCart) {
                session()->flash('toast-message', 'Product Already Added to cart');
            } else {
                Cart::create([
                    'user_id' => 0,
                    'produk_id' => $product_id,
                    'quantity' => $this->quantityCount,
                    'subtotal_harga' => $subtotalHarga,
                    'subtotal_berat' => $subtotalBerat,
                    'session_id' => $sessionId,
                ]);

                $this->dispatch('cartUpdated');
                session()->flash('toast-message', 'Product Added to cart');
            }
        }
    }
    
    public function decreaseQuantity()
    {
        if ($this->quantityCount > 1) {
            $this->quantityCount--;
        }
    }

    public function increaseQuantity()
    {
        if ($this->quantityCount < 10) {
            $this->quantityCount++;
        }
    }

    public function checkCart($product_id)
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->where('produk_id', $product_id)->exists();
        } else {
            return Cart::where('session_id', Session::getId())->where('produk_id', $product_id)->exists();
        }
    }

    public function render()
    {
        return view('livewire.produk.detail-produk');
    }
}