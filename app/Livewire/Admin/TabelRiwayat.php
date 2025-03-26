<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use App\Models\Orderdetail;
use Livewire\WithPagination;

class TabelRiwayat extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedOrder;
    public $orderId;
    public $showModal = false;
    public $orderDetails;

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
        $this->showModal = true;
    }

    public function getOrderDetail($orderId)
    {
        return Orderdetail::where('id_order', $orderId)->with('produk')->get();
    }
    
}
