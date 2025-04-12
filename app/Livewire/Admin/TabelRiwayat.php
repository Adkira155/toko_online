<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use App\Models\Orderdetail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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
