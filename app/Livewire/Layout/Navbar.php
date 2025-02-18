<?php

namespace App\Livewire\Layout;

use App\Livewire\Actions\Logout;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\Volt\Compilers\Mount;

class Navbar extends Component
{
    public $kategori;

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

        $this->redirect('/', navigate: true);
    }
}
