<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UpdateUser extends Component
{    
    public $name, $email, $nomor, $password, $role;
    public $user;
    public $id;
    public $id_user;
    

    public function mount($id) {
        $this->user = User::FindOrFail($id);

        $this->id_user = $this->user->id; 
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->nomor = $this->user->nomor;
        $this->role = $this->user->role;
        $this->password = $this->user->password;
    }
    

    public function update() {

            $this->validate([
                'name' => ['required'],
                'email' => ['required', 'email'],
                'nomor' => ['required'],
                'role' => ['required'],
                'password' => ['nullable', 'min:6'],
            ]);
        
            $user = User::findOrFail($this->id_user);
        
            // Update data user
            $user->update([
                'name' => $this->name,
                'email' => $this->email, 
                'nomor' => $this->nomor,
                'role' => $this->role,
                'password' => $this->password,
            ]);
        
            session()->flash('message', 'User berhasil diperbarui!');
            return redirect()->route('user.update', $this->id_user); 
    }

    public function back()
    {
        return redirect()->route('user.tabel');
    }

    
    public function render()
    {
        return view('livewire.admin.user.update-user');
    }
}
