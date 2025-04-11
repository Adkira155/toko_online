<div class="bg-white-100 rounded-md py-10 px-4">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">
      Halaman Review untuk <span class="text-orange-600">{{ $produk['nama'] }}</span>
    </h2>

    <a href="/" class="text-orange-600 hover:text-orange-700 flex items-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali Ke Home
    </a>

    @if (session()->has('success'))
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 3000)" 
        class="bg-green-500 text-white px-4 py-3 rounded-lg mb-4 shadow-md transition duration-500"
    >
        {{ session('success') }}
    </div>
@endif


    <div class="lg:grid lg:grid-cols-5 lg:gap-8"> {{-- grid --}}
        @if (Auth::check() && Auth::user()->role === 'user')
        <div class="bg-white p-8 rounded-lg w-full h-auto mb-6 lg:mb-0 lg:col-span-2"> {{-- form isi review --}}
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Tulis Review Anda</h3>
            @guest
                <p>Silakan <a href="{{ route('login') }}" class="text-orange-600 hover:underline">login</a> untuk memberikan review.</p>
            @else
                <form wire:submit.prevent="submit">
                    <input type="hidden" wire:model="produk_id">

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Username</label>
                        <input type="text" class="form-control w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" wire:model="username">
                        @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Komentar</label>
                        <textarea class="form-control w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" wire:model="comment" rows="4"></textarea>
                        @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition duration-300 ease-in-out font-semibold">Kirim Review</button>
                </form>
            @endguest
        </div>
        @endif

        <div class="lg:col-span-3 space-y-3"> {{-- kanan --}}
            @foreach ($reviews as $review)
                <div class="bg-white shadow-md rounded-lg p-3 m-2 border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <strong class="text-orange-600 block">{{ $review->username }}</strong>
                            <small class="text-gray-500">{{ $review->created_at->format('d M Y H:i') }}</small>
                        </div>
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <button class="text-sm text-orange-500 hover:underline mt-1" wire:click="reply({{ $review->id }})">Balas</button>
                        @endif
                        @if (Auth::check() && Auth::user()->role === 'user')
                            <button 
                                wire:click="deleteReview({{ $review->id }})" 
                                class="text-sm text-red-600 hover:underline mt-1"
                                onclick="return confirm('Yakin ingin menghapus komentar ini?')"
                                >
                            Hapus
                            </button>
                            @endif
                    </div>
                    <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>

                    {{-- Form Balasan Jika Komentar Ini Dipilih --}}
                    @if (Auth::check() && $parent_id === $review->id)
                        <div class="bg-gray-50 p-4 rounded-lg mt-3">
                            <input type="text" wire:model="replyUsername" class="w-full px-3 py-2 border rounded-lg focus:ring-orange-500 focus:outline-none mb-2" placeholder="Nama Anda">
                            @error('replyUsername') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <textarea wire:model="replyComment" class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-orange-500 focus:outline-none" placeholder="Tulis balasan..."></textarea>
                            @error('replyComment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <div class="flex space-x-2 mt-2 justify-end">
                                <button wire:click="submitReply" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">Kirim Balasan</button>
                                <button wire:click="resetReply" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Batal</button>
                            </div>
                        </div>
                    @endif

                    {{-- Menampilkan Balasan --}}
                    @foreach ($review->replies as $reply)
                        <div class=" mt-3 border-l-4 border-orange-400 pl-4 bg-gray-100 rounded-lg p-3">
                            <div class="flex justify-between items-center mb-1">
                                <strong class="text-gray-800">{{ $reply->username }}</strong>
                                
                                @if (Auth::check() && Auth::user()->role === 'admin')
                                <button 
                                wire:click="deleteReply({{ $reply->id }})"
                                class="text-sm text-red-600 hover:underline mt-1"
                                onclick="return confirm('Yakin ingin menghapus balasan ini?')"
                            >
                                Hapus
                            </button>
                            
                                @endif
                            </div>
                            <small class="text-gray-500">{{ $reply->created_at->format('d M Y H:i') }}</small>
                            <p class="text-gray-700 leading-relaxed mt-4">{{ $reply->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('notify', message => {
            let notif = document.getElementById('notification');
            notif.textContent = message;
            notif.classList.remove('hidden');
            setTimeout(() => {
                notif.classList.add('hidden');
            }, 3000);
        });
    });

    function confirmDelete(reviewId) {
        if (confirm('Yakin ingin menghapus komentar ini?')) {
            Livewire.emit('deleteReview', reviewId);
        }
    }
</script>
