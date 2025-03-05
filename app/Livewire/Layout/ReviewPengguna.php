<?php

namespace App\Livewire\Layout;

use App\Models\Review;
use Livewire\Component;

class ReviewPengguna extends Component
{
    public $id;
    public $reviews;

    public function mount($id) 
    {
        $this->id = $id;
        $this->loadReviews();
    }

    public function loadReviews()
    {
        $this->reviews = Review::where('produk_id', $this->id) 
                               ->get();
    }

    public function render()
    {
        return view('livewire.layout.review-pengguna');
    }
}