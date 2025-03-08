<div>
    <div class="bg-gray-100 rounded-md py-10 px-4">
    <div class="lg:col-span-4 col-span-1">
          <h2 class="text-2xl font-semibold text-gray-700 mb-4">
            Tambahkan review
          </h2>
        
          <a href="/" class="text-orange-600 hover:text-orange-700 flex items-center mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
           Kembali Ke Home
        </a>

          @if (session()->has('success'))
          <div id="notification" class="bg-green-500 text-white px-4 py-2 rounded-lg mb-4 shadow-md">
              {{ session('success') }}
          </div>
      @endif
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-xl">
    @guest
    <p>Silakan <a href="{{ route('login') }}">login</a> untuk memberikan review.</p>
@else
    <form wire:submit.prevent="submit">
        <input type="hidden" wire:model="produk_id">

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Username</label>
            <input type="text" class="form-control w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" wire:model="username">
            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Komentar</label>
            <textarea class="form-control w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" wire:model="comment"></textarea>
            @error('comment') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">Kirim</button>
    </form>
@endguest
    </div>
</div>
    

@foreach ($reviews as $review)
    <div class="bg-white shadow-md rounded-lg p-4 mb-4 border border-gray-200 mt-8">
        <div class="flex justify-between items-center">
            <strong class="text-blue-600">{{ $review->username }}</strong>
            <small class="text-gray-500">{{ $review->created_at->format('d M Y H:i') }}</small>
        </div>
        <p class="text-gray-700 mt-2">{{ $review->comment }}</p>

        {{-- Tombol Balas (hanya admin) --}}
        @if (Auth::check() && Auth::user()->role === 'admin')
            <button class="text-sm text-blue-500 hover:underline mt-2" wire:click="reply({{ $review->id }})">Balas</button>
        @endif

        {{-- Form Balasan Jika Komentar Ini Dipilih --}}
        @if (Auth::check() && $parent_id === $review->id)
            <div class="bg-gray-50 p-3 rounded-lg mt-2">
                <input type="text" wire:model="replyUsername" class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none" placeholder="Nama Anda">
                @error('replyUsername') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <textarea wire:model="replyComment" class="w-full mt-2 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:outline-none" placeholder="Tulis balasan..."></textarea>
                @error('replyComment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <div class="flex space-x-2 mt-2">
                    <button wire:click="submitReply" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Kirim</button>
                    <button wire:click="resetReply" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Batal</button>
                </div>
            </div>
        @endif

        {{-- Menampilkan Balasan --}}
        @foreach ($review->replies as $reply)
            <div class="ml-6 mt-3 border-l-4 border-blue-400 pl-4 bg-gray-100 rounded-lg p-3">
                <div class="flex justify-between items-center">
                    <strong class="text-gray-800">{{ $reply->username }}</strong>
                    <small class="text-gray-500">{{ $reply->created_at->format('d M Y H:i') }}</small>
                </div>
                <p class="text-gray-700 mt-2">{{ $reply->comment }}</p>
            </div>
        @endforeach
    </div>
@endforeach

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('notify', message => {
            let notif = document.getElementById('notification');
            notif.textContent = message;
            notif.classList.remove('hidden');

            // Notifikasi hilang otomatis setelah 3 detik
            setTimeout(() => {
                notif.classList.add('hidden');
            }, 3000);
        });
    });
</script>

</div>
