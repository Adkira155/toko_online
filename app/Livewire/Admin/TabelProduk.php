<?php

namespace App\Livewire\Admin;

use App\Models\Produk;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class TabelProduk extends Component
{
    use WithPagination;

    public $search = ''; 
    public $filterStatus = ''; // Untuk filter status

    public $tempSearch = ''; // Variabel sementara untuk pencarian
    public $tempFilterStatus = ''; // Variabel sementara untuk filter status

    public function applyFilter()
    {
        $this->search = $this->tempSearch;
        $this->filterStatus = $this->tempFilterStatus;
        $this->resetPage(); // Reset ke halaman pertama saat filter diterapkan
    }

    public function toggleStatus($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->status = $produk->status === 'aktif' ? 'tidak aktif' : 'aktif';
        $produk->save();
    }

    public function hapusProduk($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar jika ada
        if ($produk->image) {
            Storage::disk('public')->delete($produk->image);
        }

        // Hapus produk dari database
        $produk->delete();

        // Kirim notifikasi sukses
        $this->dispatch('alert-success', message: 'Produk berhasil dihapus.');
    }

    public function render()
    {
        $query = Produk::where('nama_produk', 'like', '%' . $this->search . '%');

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $produk = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.tabel-produk', compact('produk'));
    }
}
