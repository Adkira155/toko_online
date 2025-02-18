<?php

namespace App\Livewire\Produk;

use App\Models\produk;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;


class CreateProduk extends Component
{
    use WithFileUploads;
    #[Validate('max:10240')] 

    public $nama_produk,$harga,$deskripsi,$stok,$image,$status,$id_kategori;
    public $imageName;

    public function create(): void {
        $this->validate([
            'nama_produk' => ['required'],
            'harga' => ['required'],
            'deskripsi' => ['required'],
            'stok' => ['required','integer'],
            'status' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'id_kategori' => ['required'],
        ]);

        //cek ada image yang diupload atau tidak
        if ($this->image) {
            $imageName = $this->image->store('images', 'public');
        } else {
            $imageName = null;
        }

        produk::create([
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'deskripsi' => $this->deskripsi,
            'stok' => $this->stok,
            'status' => $this->status,
            'image' => $imageName,
            'id_kategori' => $this->id_kategori,
        ]);

        $this->dispatch('alert-success', message: 'Berhasil Menambahkan Produk Anda !!!');
    }
}
