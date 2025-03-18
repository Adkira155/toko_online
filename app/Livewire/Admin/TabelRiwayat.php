<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class TabelRiwayat extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedOrder;
    public $orderId;
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
            ->where('status', 'completed') 
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.tabel-riwayat', [
            'orders' => $orders,
        ]);
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
}