<div>
    <h4>Tambahkan Review</h4>
    <form wire:submit.prevent="submit">
        <input type="hidden" wire:model="produk_id">

        <div class="mb-2">
            <label>Username:</label>
            <input type="text" class="form-control" wire:model="username">
            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-2">
            <label>Komentar:</label>
            <textarea class="form-control" wire:model="comment"></textarea>
            @error('comment') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button class="btn btn-primary btn-sm">Kirim</button>
    </form>

    <hr>

    <h4>Komentar</h4>
    @foreach ($reviews as $review)
        <div class="border p-2 mb-2">
            <strong>{{ $review->username }}</strong> 
            <p>{{ $review->comment }}</p>

            @if (Auth::user()->role === 'admin')
            <button class="btn btn-link btn-sm" wire:click="reply({{ $review->id }})">Balas</button>
            @endif

            {{-- Tampilkan Form Balasan Jika Komentar Ini yang Dipilih --}}
            @if ($parent_id === $review->id)
                <div class="ms-4 p-2">
                    <input type="text" wire:model="replyUsername" class="form-control" placeholder="Nama Anda">
                    @error('replyUsername') <span class="text-danger">{{ $message }}</span> @enderror

                    <textarea wire:model="replyComment" class="form-control mt-2" placeholder="Tulis balasan..."></textarea>
                    @error('replyComment') <span class="text-danger">{{ $message }}</span> @enderror

                    <button wire:click="submitReply" class="btn btn-primary btn-sm mt-2">Kirim Balasan</button>
                    <button wire:click="resetReply" class="btn btn-secondary btn-sm mt-2">Batal</button>
                </div>
            @endif

            {{-- Menampilkan Balasan --}}
            @foreach ($review->replies as $reply)
                <div class="ms-4 p-2 border-start">
                    <strong>{{ $reply->username }}</strong>
                    <p>{{ $reply->comment }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
