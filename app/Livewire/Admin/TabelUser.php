<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
class TabelUser extends Component
{
    
    public $users, $data;
    public $search = ''; 

    public function render()
    {
        $user = User::where('name', 'like', '%' . $this->search . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
        return view('livewire.admin.tabel-user', compact('user'));
    }
    
    public function hapusUser($id)
    {
        $user = User::findOrFail($id);
    
        // Hapus produk dari database
        $user->delete();
    
        // Refresh data produk
        $this->users = User::latest()->get();
    
        // Kirim notifikasi sukses
        $this->dispatch('alert-success', message: 'Produk berhasil dihapus.');
    }
}