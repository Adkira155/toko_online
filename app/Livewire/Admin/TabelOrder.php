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
    public $order;
    public $search = '';
    protected $paginationTheme = 'paginate';

    public function render()
    {
        $orders = Order::where('id_user', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.tabel-order', [
            'orders' => $orders,
        ]);
    }

    public function mount(): void
    {
    }

    public function hapusOrder($id)
    {
        $order = Order::findOrFail($id);

        $order->delete();

        $this->dispatch('alert-success', message: 'Data Pesanan berhasil dihapus.');
        $this->dispatch('refreshTable');
    }
}