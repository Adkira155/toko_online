<?php

namespace App\Livewire\Produk;

use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\Component;

class DataProduk extends Component
{
    use WithPagination;

    public $data;

    protected $paginationTheme = 'paginate';

    public function mount(): void
    {
        // Tidak perlu memproses paginasi di sini
        $this->data = Auth::user(); // Simpan data pengguna untuk referensi
    }

    public function hapusProduk($id): void
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($produk->image) {
            Storage::disk('public')->delete($produk->image);
        }

        $produk->delete();

        // Kirim notifikasi ke pengguna
        $this->dispatchBrowserEvent('alert-success', ['message' => 'Produk berhasil dihapus.']);
    }

    public function render()
    {
        $produks = Produk::query();
    
        // Filter berdasarkan role user
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                $produks = $produks->where('status', 'aktif');
            }
        } else {
            $produks = $produks->where('status', 'aktif');
        }
    
        return view('livewire.produk.data-produk', [
            'produks' => $produks->latest()->paginate(8),
        ]);
    }
    
}
