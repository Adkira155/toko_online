<?php

namespace App\Livewire\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class CreateKategori extends Component
{

    public $nama;

    public function create(): void {
        $this->validate([
            'nama' => ['required'],
        ]);

        Kategori::create([
            'nama' => $this->nama,
        ]);

        $this->dispatch('alert-success', message: 'Berhasil Menambahkan Kategori Baru !!!');
    }
}
