<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CreateCart extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = $this->getUserCart();
    }

    public function getUserCart()
    {
        $userId = Auth::id();
        $cart = Session::get('cart', []);

        return array_filter($cart, function ($item) use ($userId) {
            return $item['user_id'] == $userId;
        });
    }

    public function updateQuantity($id, $action)
    {
        if (isset($this->cart[$id])) {
            if ($action === 'increase') {
                $this->cart[$id]['quantity']++;
            } elseif ($action === 'decrease' && $this->cart[$id]['quantity'] > 1) {
                $this->cart[$id]['quantity']--;
            }
        }
        Session::put('cart', $this->cart);
    }

    public function removeFromCart($id)
    {
        unset($this->cart[$id]);
        Session::put('cart', $this->cart);
    }

    public function getSubtotalProperty()
    {
        return array_reduce($this->cart, function ($total, $item) {
            return $total + ($item['harga'] * $item['quantity']);
        }, 0);
    }

    public function getTotalProperty()
    {
        $shipping = 10000;
        return $this->subtotal + $shipping;
    }

    public function render()
    {
        return view('livewire.cart.create-cart', [
            'cart' => $this->cart,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
        ]);
    }
}


//     public function render()
//     {
//         return view('livewire.cart.create-cart');
//     }
// }
