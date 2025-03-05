<div class="bg-gray-100 py-10 flex justify-center mt-16">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-3xl">
        <h2 class="text-xl font-semibold mb-4 text-center">Review Pengguna</h2>

        <div class="space-y-4">
            @forelse ($reviews as $review)
                <div class="p-6 border rounded-lg bg-white shadow-lg flex items-center space-x-6 relative">
                    @if ($review->user)
                        <img class="w-14 h-14 rounded-full" src="{{ $review->user->profile_picture_url }}" alt="Profile picture">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900">{{ $review->user->name }} <span class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</span></p>
                            <p class="text-gray-700 mt-1">{{ $review->comment }}</p>
                        </div>
                    @else
                        <div class="flex-1">
                            <p class="font-bold text-gray-900">{{ $review->username }} <span class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</span></p>
                            <p class="text-gray-700 mt-1">{{ $review->comment }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <p>Belum ada review untuk produk ini.</p>
            @endforelse
        </div>

        </div>
</div>