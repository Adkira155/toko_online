<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use App\Livewire\Actions\Logout;

class Footer extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/');

        $this->dispatch('swal:confirmLogout');
    }
    
    public function render()
    {
        return view('livewire.layout.footer');
    }
}
