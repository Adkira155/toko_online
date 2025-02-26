<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Actions\Logout;

class sidebar extends Component
{
    public function render()
    {
        return view('livewire.layout.sidebar');
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}
