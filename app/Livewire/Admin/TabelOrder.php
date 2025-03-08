<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class TabelOrder extends Component
{
    use WithPagination;

    public $data;
    public $order;
    public $search = '';
    protected $paginationTheme = 'paginate';

    public $selectedOrder;


    public function render()
    {
        $orders = Order::with(['user', 'orderdetail.produk'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('orderdetail.produk', function ($query) {
                $query->where('nama_produk', 'like', '%' . $this->search . '%');
            })
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

    public function showOrders($id)
    {
        $this->selectedOrder = Order::with(['user', 'orderdetail.produk'])->findOrFail($id);
    
    //    dd($this->selectedOrder->toArray());
    }

    public function closeModal()
    {
        $this->selectedOrder = null;
    }

}