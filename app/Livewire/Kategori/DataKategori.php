<?php

namespace App\Livewire\Kategori;

use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataKategori extends Component
{
    public $kategori,$data;

    public function mount(): void
    {
        $this->kategori = Kategori::latest()->get();
    }

    public function delete($id): void
    {
        if ($this->data->role === 'admin') {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        }
        $this->dispatch('alert-success', message: 'Kategori berhasil dihapus.');
    }
}
