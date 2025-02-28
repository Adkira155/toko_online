<?php

namespace App\Livewire\Produk;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produk;
use App\Models\Kategori;

class ProdukPage extends Component
{
    public $random;

    public function mount()
    {
        $this->random = produk::inRandomOrder()->get();
    }

    public function render()
    {
        return view('livewire.produk.produk-page');
    }
}
