<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Orderdetail;
use Livewire\Component;
use Livewire\WithPagination;

class TabelOrder extends Component
{
    use WithPagination;

    public $search = '';
    public $statuses = ['paid', 'pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    
    public $selectedOrder;
    public $orderId;
    public $orderDetails;
    public $status;
    public $showModal = false;

    public function render()
    {
        $orders = Order::with(['user', 'orderdetail.produk'])
            ->where(function ($query) {
                $query->whereHas('user', function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('orderdetail.produk', function ($subQuery) {
                    $subQuery->where('nama_produk', 'like', '%' . $this->search . '%');
                });
            })
            ->where('status', '!=', 'completed') // Tambahkan filter status disini
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
        $this->orderDetails = $this->getOrderDetail($id); // Tambahkan baris ini
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
        if (!in_array($this->status, ['paid','pending', 'processing', 'shipped', 'delivered', 'cancelled'])) {
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

    public function getOrderDetail($orderId)
    {
        return Orderdetail::where('id_order', $orderId)->with('produk')->get();
    }
    
}
