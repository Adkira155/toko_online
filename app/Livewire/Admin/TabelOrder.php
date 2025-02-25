<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class TabelOrder extends Component
{
    use WithPagination;

    public $data;
    public $orders;
    public $search = ''; 
    protected $paginationTheme = 'paginate';

    public function render()
    {
        $order = Order::where('id_user', 'like', '%' . $this->search . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
        return view('livewire.admin.tabel-order', compact('order'));
    }

    public function mount(): void
    {
      
    }

    public function hapusOrder($id): void
    {
        $order = Order::findOrFail($id);

        $order->delete();

        // Kirim notifikasi ke pengguna
        $this->dispatchBrowserEvent('alert-success', ['message' => 'Order berhasil dihapus.']);
    }   
}

//     public function render()
//     {
//         return view('livewire.admin.tabel-order');
//     }
// }
