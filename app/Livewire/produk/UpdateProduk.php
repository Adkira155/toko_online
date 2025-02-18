<?php

namespace App\Livewire\Produk;

use App\Models\produk;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class UpdateProduk extends Component
{
    use WithFileUploads;
    #[Validate('max:10240')] 

    public $nama,$harga,$deskripsi,$stok,$image,$id_kategori,$status;
    public $cekImage;
    public $id;
    // public $id = Produk::findorFail($id);

    public function mount($id) {
        $produk = produk::findOrFail($id);

        // Set nilai properti berdasarkan data voucher
        $this->id = $produk->id;
        $this->nama = $produk->nama;
        $this->harga = $produk->harga;
        $this->deskripsi = $produk->deskripsi;
        $this->stok = $produk->stok;
        $this->image = $produk->image;
        $this->id_kategori = $produk->id_kategori;
        $this->status = $produk->status;
       
    }

    public function update(): void {
        // Validasi input
        $produk = Produk::findOrFail($this->id);
        $this->validate([
            'nama_produk' => ['required'],
            'harga' => ['required'],
            'deskripsi' => ['required'],
            'stok' => ['required','integer'],
            'status' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'id_kategori' => ['required'],
        ]);

        if ($this->image) {
            if ($this->cekImage) {
                Storage::disk('public')->delete($this->cekImage); 
            }
            $imageName = $this->image->store('produk', 'public');
        } else {
            $imageName = $this->cekImage;
        }

        $produk->update([
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'deskripsi' => $this->deskripsi,
            'stok' => $this->stok,
            'status' => $this->status,
            'image' => $imageName,
        ]);

        $this->dispatch('alert-success', message: 'Berhasil Memperbarui Produk Anda !!!');
    }
}
