<?php

namespace App\Livewire\User;

use App\Models\Order;
use App\Models\OrderDetail;
use Livewire\Component;
use Livewire\WithPagination;

class Status extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $selectedOrder = null;

    public function render()
    {
        $orders = Order::where('id_user', auth()->id())
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('id', 'like', '%' . $this->search . '%')
                        ->orWhere('resi_code', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('livewire.user.status', [
            'orders' => $orders,
        ]);
    }

    public function markAsCompleted($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->status === 'delivered' && $order->id_user === auth()->id()) {
            $order->status = 'completed';
            $order->save();
            $this->dispatch('order-status-updated');
            $this->closeModal('orderModal' . $orderId);
        }
    }

    public function closeModal($modalId)
    {
        $this->dispatch('closeModal', modalId: $modalId);
    }

    public function getOrderDetail($orderId)
    {
        return OrderDetail::where('id_order', $orderId)->with('produk')->get();
    }
}