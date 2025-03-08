<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class TabelOrder extends Component
{
    use WithPagination;

    public $search = '';
    public $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    
    public $selectedOrder;
    public $orderId;
    public $status;
    public $showModal = false;

    protected $paginationTheme = 'bootstrap';

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

    public function hapusOrder($id)
    {
        Order::findOrFail($id)->delete();
        session()->flash('message', 'Data Pesanan berhasil dihapus.');
        $this->dispatch('refreshTable');
    }

    public function showOrders($id)
    {
        $this->selectedOrder = Order::with(['user', 'orderdetail.produk'])->findOrFail($id);
    }

    public function closeModal()
    {
        $this->selectedOrder = null;
        $this->showModal = false;
    }

    public function openModal($orderId)
    {
        $this->orderId = $orderId;
        $order = Order::findOrFail($orderId);
        $this->status = $order->status;
        $this->showModal = true;
    }

    public function updateStatus()
    {
        if (!in_array($this->status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])) {
            session()->flash('error', 'Status tidak valid.');
            return;
        }
    
        Order::where('id', $this->orderId)->update([
            'status' => $this->status,
        ]);
    
        $this->showModal = false;
        session()->flash('message', 'Status berhasil diperbarui.');
        $this->dispatch('refreshTable');
    }
    
}
