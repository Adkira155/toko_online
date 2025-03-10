<?php

namespace App\Livewire\Produk;

use App\Models\Cart;
use App\Models\Produk;
use Livewire\Component;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DetailProduk extends Component
{
    public $id;
    public $data;
    public $kategori;
    public $quantityCount = 1;
    public $errorMessage = '';
    public $successMessage = '';

    public function mount($id): void
    {
        $this->id = $id;
        $this->data = produk::findOrFail($id);
        // $this->kategori = Kategori::all();
        // dd($this->data);
    } 

    public function addToCart($product_id)
    {
        // Cek apakah pengguna login
        if (!Auth::check()) {
            $this->errorMessage = 'Silakan login untuk menambahkan produk ke keranjang.';
            $this->successMessage = ''; // Reset success message
            return;
        }
    
        $product = Produk::find($product_id);
    
        if (!$product || $product->status !== 'aktif') {
            abort(404);
        }
    
        if ($product->stok <= 0) {
            $this->errorMessage = 'Produk habis.';
            $this->successMessage = '';
            return;
        }
    
        if ($product->stok < $this->quantityCount) {
            $this->errorMessage = "Stok tersedia hanya {$product->stok}.";
            $this->successMessage = '';
            return;
        }
    
        $subtotalHarga = $product->harga * $this->quantityCount;
        $subtotalBerat = $product->berat * $this->quantityCount;
    
        if (Cart::where('user_id', Auth::id())->where('produk_id', $product_id)->exists()) {
            $this->errorMessage = 'Produk sudah ada di keranjang.';
            $this->successMessage = '';
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'produk_id' => $product_id,
                'quantity' => $this->quantityCount,
                'subtotal_harga' => $subtotalHarga,
                'subtotal_berat' => $subtotalBerat,
                'status' => 'keranjang',
            ]);
    
            $this->errorMessage = ''; // Reset error message
            $this->successMessage = 'Produk berhasil ditambahkan ke keranjang!';
    
            $this->dispatch('cartUpdated'); // Trigger event untuk update cart
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

    public function render()
    {
        return view('livewire.produk.detail-produk', [
            'data' => $this->data,
        ]);
    }
}
