<?php

namespace App\Livewire\Admin;

use App\Models\produk;
use App\Models\User;
// use App\Livewire\Layout\Produk;
use Livewire\Component;


class DashboardAdmin extends Component
{
    public $totalProduk;
    public $totalStok;
    public $totalPelanggan;

    public function mount()
    {
        $this->totalProduk = Produk::count();
        $this->totalStok = Produk::sum('stok');
        $this->totalPelanggan = User::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-admin');
    }

    
}

//     public function render()
//     {
//         return view('livewire.admin.dashboard-admin');
//     }
// }
