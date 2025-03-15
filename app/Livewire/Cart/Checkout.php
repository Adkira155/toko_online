<?php

namespace App\Livewire\Cart;

use App\Services\BinderbyteService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component
{
    public function render()
    {
        return view('livewire.cart.checkout');
    }
}