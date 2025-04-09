<div class="bg-white-100 mt-8 rounded-md">
    <div class="max-w-full  sm:px-6 lg:px-8">

        <div class="space-y-3">
            @forelse ($reviews as $review)
                {{-- Kondisi ini anya tampilkan review utama (parent_id null) --}}
                @if ($review->parent_id === null)
                    <div class="bg-white rounded-lg shadow-md p-5 border border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out m-2"> {{-- User Review --}}
                        <div class="flex items-start space-x-3">
                            @if ($review->user)
                                <div class="flex-shrink-0">
                                    <img class="w-10 h-10 rounded-full object-cover border border-gray-300 shadow-sm align-top" src="{{ $review->user->profile_picture_url }}" alt="Foto Profil {{ $review->user->name }}">
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-baseline justify-between mb-2">
                                        <p class="text-lg font-semibold text-gray-900">{{ $review->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</p>
                                    </div>
                                    <p class="text-gray-800 leading-relaxed">{{ $review->comment }}</p>
                                </div>
                            @else
                                <div class="flex-1">
                                    <div class="flex items-baseline justify-between mb-2">
                                        <p class="text-lg font-semibold text-gray-900">{{ $review->username }}</p>
                                        <p class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</p>
                                    </div>
                                    <p class="text-gray-800 leading-relaxed">{{ $review->comment }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- Kolom Balasan: Hanya tampil jika ada balasan --}}
                        @if ($review->replies && count($review->replies) > 0)
                            <div class="ml-6 mt-3"> {{-- Indentation container for replies --}}
                                @foreach ($review->replies as $reply)
                                    <div class="bg-gray-100 rounded-md p-4 border border-gray-200 mb-2"> {{-- Styled reply container --}}
                                        <div class="flex items-baseline justify-between mb-1">
                                            <p class="text-sm font-semibold text-blue-600">Admin</p> {{-- Indicate it's an admin reply --}}
                                            <p class="text-xs text-gray-500">{{ $reply->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">{{ $reply->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Form Balasan (Admin) --}}
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <div class="ml-6 mt-3">
                                <form wire:submit.prevent="submitReply({{ $review->id }})"> {{-- Assuming you have a submitReply function --}}
                                    <textarea wire:model="replyComment.{{ $review->id }}" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-blue-500" rows="2" placeholder="Balas review ini..."></textarea>
                                    @error("replyComment.{{ $review->id }}") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    <div class="flex justify-end mt-2">
                                        <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">Kirim Balasan</button>
                                        @if ($parent_id === $review->id)
                                            <button type="button" wire:click="resetReply" class="ml-2 bg-gray-300 text-gray-700 px-3 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">Batal</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif
            @empty
                <div class="text-gray-600 py-4 px-4 rounded-md bg-white-50 text-center">
                    Belum ada review untuk produk ini.
                </div>
            @endforelse
        </div>
    </div>
</div>