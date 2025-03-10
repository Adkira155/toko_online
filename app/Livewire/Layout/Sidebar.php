<?php

namespace App\Livewire;

use view;
use Livewire\Component;
use App\Livewire\Actions\Logout;

class sidebar extends Component
{
    public function render()
    {
        return view('livewire.layout.sidebar');
    }

}
