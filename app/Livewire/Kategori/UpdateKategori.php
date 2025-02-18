<?php

namespace App\Livewire\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class UpdateKategori extends Component
{
    public $nama,$id;

    public function mount($id) {
        // Dapatkan voucher berdasarkan ID
        $data = Kategori::findOrFail($id);

        // Set nilai properti berdasarkan data voucher
        $this->id = $data->id;
        $this->nama = $data->nama;
    }

    public function update(): void {
        // Validasi input
        $this->validate([
            'nama' => ['required'],
        ]);

        $data = Kategori::findOrFail($this->id);

        // Update data 
        $data->update([
            'nama' => $this->nama,
        ]);

        $this->dispatch('alert-success', message: 'Berhasil Memperbarui Kategori Baru !!!');
    }
}
