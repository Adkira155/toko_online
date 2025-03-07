<?php

namespace App\Livewire\Cart;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component
{
    public $namaPenerima;
    public $nomorTelepon;
    public $alamat;
    public $catatan;

    public function mount()
    {
        $user = Auth::user();
        if ($user) {
            $this->namaPenerima = $user->name;
            $this->nomorTelepon = $user->nomor;
            $this->alamat = $user->alamat;
        }
    }

    public function render()
    {
        return view('livewire.cart.checkout');
    }
}