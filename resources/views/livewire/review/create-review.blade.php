<div>

    <div class="lg:col-span-4 col-span-1">
        <form action="" method="POST" class="space-y-4">
          <h2 class="text-2xl font-semibold text-gray-700 mb-4 ml-14">
            Tambahkan review
          </h2>
          
          <div class="bg-gray-100 py-10 px-4">
            <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-xl ml-16">
              
                    
                    <form wire:submit.prevent="submit">
                        <input type="hidden" wire:model="produk_id">
        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-1">Username:</label>
                            <input type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" wire:model="username">
                            @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-1">Komentar:</label>
                            <textarea class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" wire:model="comment"></textarea>
                            @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
        
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">
                            Kirim
                        </button>
                    </form>
          
            </div>
        </div>
        

    @guest
        <p>Silakan <a href="{{ route('login') }}">login</a> untuk memberikan review.</p>
    @else
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
    @endguest

    <hr>

    <h4>Komentar</h4>
    @foreach ($reviews as $review)
        <div class="border p-2 mb-2">
            <strong>{{ $review->username }}</strong> 
            <small class="text-muted">{{ $review->created_at->format('d M Y H:i') }}</small>
            <p>{{ $review->comment }}</p>

            @if (Auth::check() && Auth::user()->role === 'admin')
                <button class="btn btn-link btn-sm" wire:click="reply({{ $review->id }})">Balas</button>
            @endif

            {{-- Tampilkan Form Balasan Jika Komentar Ini yang Dipilih --}}
            @if (Auth::check() && $parent_id === $review->id)
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
                    <small class="text-muted">{{ $reply->created_at->format('d M Y H:i') }}</small>
                    <p>{{ $reply->comment }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
