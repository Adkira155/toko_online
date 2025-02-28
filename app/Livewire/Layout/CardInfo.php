<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use App\Models\Produk;

class CardInfo extends Component
{
    public $search = '';
    public $produk = [];

    public function mount()
    {
        // Memuat produk saat pertama kali halaman dibuka
        $this->produk = Produk::all();
    }

    public function applySearch()
    {
        // Query pencarian
        $this->produk = Produk::where('nama_produk', 'like', '%' . $this->search . '%')->get();
    }

    public function render()
    {
        return view('livewire.layout.card-info');
    }
}
