<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use App\Models\Orderdetail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TabelOrder extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $statuses = ['paid', 'pending', 'processing', 'shipped', 'delivered', 'cancelled'];

    public $selectedOrder;
    public $orderId;
    public $orderDetails;
    public $status;
    public $showModal = false;

    public function render()
    {
        $orders = Order::with(['user', 'orderdetail.produk'])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->whereHas('user', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('invoice', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->where('status', '!=', 'completed')
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

    public function getProvinceName($id)
    {
        return Cache::remember("provinsi_$id", now()->addDay(), function () use ($id) {
            $response = Http::get('https://api.binderbyte.com/wilayah/provinsi', [
                'api_key' => env('BINDERBYTE_API_KEY')
            ]);

            if ($response->successful()) {
                $provinsi = collect($response->json('value'))->firstWhere('id', $id);
                return $provinsi ? $provinsi['name'] : 'Provinsi tidak ditemukan';
            }

            return 'Gagal mengambil data provinsi';
        });
    }

    public function getCityName($id_provinsi, $id_kota)
    {
        return Cache::remember("kota_{$id_provinsi}_{$id_kota}", now()->addDay(), function () use ($id_provinsi, $id_kota) {
            $response = Http::get('https://api.binderbyte.com/wilayah/kabupaten', [
                'api_key' => env('BINDERBYTE_API_KEY'),
                'id_provinsi' => $id_provinsi,
            ]);

            if ($response->successful()) {
                $kota = collect($response->json('value'))->firstWhere('id', $id_kota);
                return $kota ? $kota['name'] : 'Kota tidak ditemukan';
            }

            return 'Gagal mengambil data kota';
        });
    }
    
}
