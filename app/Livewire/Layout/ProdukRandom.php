<?php

namespace App\Livewire\Layout;

use App\Models\produk;
use Livewire\Component;

class ProdukRandom extends Component
{
    public $random;

    public function mount()
    {
        // Fetch random products, limit to 4 or whatever number you want
        $this->random = produk::inRandomOrder()->limit(4)->get();
    }

    public function render()
    {
        return view('livewire.layout.produk-random');
    }
}
