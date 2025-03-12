<?php

namespace App\Livewire\Layout;

use App\Livewire\Actions\Logout;
use App\Models\Kategori;
use Livewire\Component;



class Navbar extends Component
{
    public $kategori;

    protected $listeners = ['logout', 'redirectTo', 'swal:success'];

    public function mount(): void {
        $this->kategori = Kategori::all();
    }
    public function render()
    {
        return view('livewire.layout.navbar', [
            'kategori' => $this->kategori,
        ]);
    }


public function logout(Logout $logout): void
{
    $logout();
    $this->redirect('/');

    $this->dispatch('swal:confirmLogout');
}

// public function swalSuccess($message)
// {
//     $this->dispatch('swal:success', [
//         'title' => $message['title'],
//         'text' => $message['text']
//     ]);
// }



}
