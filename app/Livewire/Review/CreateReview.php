<?php
namespace App\Livewire\Review;

use App\Models\Produk;
use App\Models\Review;
use Livewire\Component;

class CreateReview extends Component
{
    public $produk_id, $username, $comment, $parent_id;
    public $produk;
    public $replyUsername, $replyComment;

    public function mount($produk_id)
    {
        $this->produk_id = $produk_id;
        $this->produk = Produk::findOrFail($produk_id);
    }

    protected $rules = [
        'username' => 'required|string|max:255',
        'comment' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();
    
        if (!$this->produk_id) {
            session()->flash('error', 'Terjadi kesalahan: Produk tidak ditemukan.');
            return;
        }
    
        Review::create([
            'produk_id' => $this->produk_id,
            'parent_id' => $this->parent_id,
            'username' => $this->username,
            'comment' => $this->comment,
        ]);

        session()->flash('success', 'Komentar berhasil dikirim!');
    
        $this->reset(['username', 'comment', 'parent_id']); 
    }

    public function render()
    {
       // dd($this->produk_id); 
        $reviews = Review::where('produk_id', $this->produk_id)
                        ->whereNull('parent_id')
                        ->with('replies')
                        ->latest()
                        ->get();

        return view('livewire.review.create-review', compact('reviews'));
    }

    
    public function reply($reviewId)
    {
        $this->parent_id = $reviewId;
        $this->replyUsername = '';
        $this->replyComment = '';
    }
    
    public function submitReply()
    {
        $this->validate([
            'replyUsername' => 'required',
            'replyComment' => 'required',
        ]);
    
        Review::create([
            'produk_id' => $this->produk_id,
            'parent_id' => $this->parent_id,
            'username' => $this->replyUsername,
            'comment' => $this->replyComment,
        ]);
    
        $this->resetReply();
    }
    
    public function resetReply()
    {
        $this->parent_id = null;
        $this->replyUsername = '';
        $this->replyComment = '';
    }
}