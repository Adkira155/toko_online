<?php

namespace App\Livewire\Review;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class DataReview extends Component
{
        use WithPagination;

        public function render()
        {
            return view('livewire.review.data-review', [
                'reviews' => Review::latest()->paginate(5)
            ]);
        }
    
  //      return view('livewire.review.data-review');
}
