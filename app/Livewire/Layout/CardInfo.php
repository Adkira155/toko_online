<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Livewire\WithPagination;
// use App\Livewire\Layout\Produk;
use App\Models\Produk;


class CardInfo extends Component
{
   public $produks,$data;
   public $search = '';

    public function render()
    {
        $produk = Produk::all();

        return view('livewire.layout.card-info', compact('produk'));
    }
}
