<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\produk;
// use App\Livewire\Layout\Produk;
use Livewire\Component;
use Illuminate\Support\Carbon;


class DashboardAdmin extends Component
{
    public $totalProduk;
    public $totalStok;
    public $totalPelanggan;
    public $totalPesanan;
    public $totalPending;
    public $totalProses;
    public $totalSelesai;
    public $totalPesananPerBulan;

    public function mount()
    {
        $this->totalProduk = Produk::count();
        $this->totalStok = Produk::sum('stok');
        $this->totalPelanggan = User::count();
        $this->totalPesanan = Order::count();

        $this->totalPending = Order::where('status', 'pending')->count();
        $this->totalProses = Order::where('status', 'processing')->count();
        $this->totalSelesai = Order::where('status', 'completed')->count();

        $this->totalPesananPerBulan = Order::where('status', 'completed')
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();



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
