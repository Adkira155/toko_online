<div id="produk-section" class="products-section bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 sm:mb-8 gap-4 sm:gap-0">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 text-center sm:text-left">
                Jelajahi Produk Kami
            </h2>
        
            <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 w-full sm:w-auto">
                <!-- Search Bar -->
                <input type="text" wire:model.defer="search" placeholder="Search products..."  
                    class="w-full sm:w-auto px-4 py-2 border border-gray-200 rounded-lg 
                           focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                
                    <button wire:click="applySearch" 
                        class="ml-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
                           Cari
                    </button>
            </div>
        </div>
        

        <!-- Products Grid -->
        @if ($produk && $produk->count() > 0)
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($produk as $p)
                <div class="product-card bg-white overflow-hidden shadow-sm rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <a href="{{ url('/produk-detail/' . $p->id) }}" class="block">
                        <img src="{{ asset('storage/' . $p->image) }}" alt="Product" class="w-full h-40 sm:h-48 md:h-56 object-cover rounded-t-lg">
                        <div class="p-4">
                            <h3 class="product-name text-lg font-bold text-gray-900">{{ $p->nama_produk }}</h3>
                            <span class="bg-softoren text-white text-xs uppercase px-2 py-1 rounded">
                                {{ $p->kategoris->nama ?? '-' }}
                            </span>
                           

                            <p class="text-gray-500 text-sm mt-2 truncate">{{ $p->deskripsi }}</p>
                            <p class="text-lg font-semibold text-gray-900 mt-3">Rp. {{ number_format($p->harga, 0, ',', '.') }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <button class="text-lg font-semibold text-[#fb9229]">
                                    <a href="{{ route('produk.detail', ['id' => $p->id]) }}">lihat detail</a>
                                </button>
                            </div>
                        </div>
                    </a>
                    </div>
                @endforeach
            </div>

            <!-- Load More Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('produk.page') }}">
                    <x-primary-button class="px-6 py-3 text-white font-semibold rounded-lg transition">
                        Load More
                    </x-primary-button>
                </a>
            </div>
        @else
            <div id="noResults" class="text-center py-12">
                <h3 class="text-lg font-medium text-gray-900">Produk tidak ditemukan</h3>
                <p class="mt-2 text-gray-500">Coba lagi dengan kata kunci lain</p>
            </div>
        @endif
    </div>
</div>