<?php

namespace App\Livewire\Admin;

use App\Models\Produk;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class TabelProduk extends Component
{
    use WithPagination;

    public $produks, $data;
    public $search = ''; // Untuk pencarian

    public function render()
    {
        $produk = Produk::where('nama_produk', 'like', '%' . $this->search . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
        return view('livewire.admin.tabel-produk', compact('produk'));
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
    
        // Refresh data produk
        $this->produks = Produk::latest()->get();
    
        // Kirim notifikasi sukses
        $this->dispatch('alert-success', message: 'Produk berhasil dihapus.');
    }
}