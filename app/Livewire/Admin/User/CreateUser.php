<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;

class CreateUser extends Component
{
  //  use WithFileUploads;

    public $name, $email, $nomor, $password;
    public $role;

    public function mount()
    {
       
    }

    public function create(): void {
        $this->validate([
            'name' => ['required'],
            'email' => ['required'],
            'nomor' => ['required'],
            'role' => ['required'],
            'password' => ['required'],
        ]);
        
        // Simpan produk
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'nomor' => $this->nomor,
            'role' => $this->role,
            'password' => $this->password,
        ]);

        // Notifikasi sukses
        $this->dispatch('alert-success', message: 'Berhasil Menambahkan Produk Anda !!!');
        // Reset form setelah submit
        $this->reset(['name', 'email', 'nomor', 'role', 'password']);
    }

    public function back()
    {
        return redirect()->route('user.tabel');
    }

    public function render()
    {
        return view('livewire.admin.user.create-user');
    }
}
