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
    public $filterStatus = '';
    public $tempSearch = '';
    public $tempFilterStatus = '';
    public $selectedProduk = null;

    protected $listeners = [
        'refreshTable' => '$refresh',
        'konfirmasiHapus' => 'hapusProduk'
    ];
    
    
    public function showSwal($data)
{
    $this->dispatch('swal', $data);
}

    public function showProduct($id)
    {
        $this->selectedProduk = Produk::findOrFail($id);
    }

    public function closeModal()
    {
        $this->selectedProduk = null;
    }

    public function applyFilter()
    {
        $this->search = $this->tempSearch;
        $this->filterStatus = $this->tempFilterStatus;
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->status = $produk->status === 'aktif' ? 'tidak aktif' : 'aktif';
        $produk->save();

        $this->dispatch('alert-success', message: 'Status produk diperbarui.');
        $this->dispatch('refreshTable');
    }
    

    public function hapusProduk($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->image) {
            Storage::disk('public')->delete($produk->image);
        }

        $produk->delete();

        $this->dispatch('refreshTable');

        // Tampilkan notifikasi sukses dengan SweetAlert
        $this->dispatch('swal', [
            'title' => 'Berhasil!',
            'text' => 'Produk berhasil dihapus.',
            'icon' => 'success',
            'timer' => 10000
        ]);
       
    }

    public function render()
    {
        $produk = Produk::query()
            ->when($this->search, fn($query) => $query->where('nama_produk', 'like', '%' . $this->search . '%'))
            ->when($this->filterStatus, fn($query) => $query->where('status', $this->filterStatus))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.tabel-produk', compact('produk'));
    }
}
