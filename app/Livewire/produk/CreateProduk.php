<?php

namespace App\Livewire\Produk;

use App\Models\produk;
use Livewire\Component;
use App\Models\Kategori;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;


class CreateProduk extends Component
{
    use WithFileUploads;

    public $nama_produk, $harga, $deskripsi,$berat, $stok, $image, $kategori;
    public $id_kategori;

    public function mount()
    {
        // Mengambil semua kategori untuk dropdown
        $this->id_kategori = Kategori::all();
    }

    public function create(): void {
        $this->validate([
            'nama_produk' => ['required'],
            'harga' => ['required'],
            'berat' => ['required'],
            'deskripsi' => ['required'],
            'stok' => ['required', 'integer'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'kategori' => ['required'], // Pastikan kategori dipilih
        ]);

        // Simpan gambar jika diunggah
        if ($this->image) {
            $imageName = $this->image->store('images', 'public');
        } else {
            $imageName = null;
        }
        
        // Simpan produk
        Produk::create([
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'deskripsi' => $this->deskripsi,
            'stok' => $this->stok,
            'berat' => $this->berat,
            'image' => $imageName,
            'id_kategori' => $this->kategori,
        ]);

        // Notifikasi sukses
        $this->dispatch('alert-success', message: 'Berhasil Menambahkan Produk Anda !!!');
        // Reset form setelah submit
        $this->reset(['nama_produk', 'harga', 'deskripsi', 'stok', 'berat', 'image', 'kategori']);
    }

    public function back()
    {
        return redirect()->route('tabel.produk');
    }

    public function render()
    {
        return view('livewire.produk.create-produk');
    }
}