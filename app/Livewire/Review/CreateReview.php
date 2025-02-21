<?php
namespace App\Livewire\Review;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateReview extends Component
{
    public $review;
    public $user_id;
    public $produk_id;
    public $data;

    public function mount(): void
    {
        $this->user_id = Auth::id();
        $this->data = Review::where('user_id', $this->user_id)
                            ->where('produk_id', $this->produk_id)
                            ->first();
    }
    

    public function create(): void
    {
        $this->validate([
            'review' => 'required',
        ]);
       
       dd($this->data);

       dd($this);

        Review::create([
            'review'    => $this->review,
            'reply'     => null,
            'user_id'   => $this->user_id,
            'produk_id' => $this->produk_id,
        ]);
      

        $this->dispatch('alert-success', 'Berhasil Menambahkan Review Anda !!!');

        $this->reset('review'); // Reset input setelah submit
    }

    public function render()
    {
        return view('livewire.review.create-review');
    }
}
