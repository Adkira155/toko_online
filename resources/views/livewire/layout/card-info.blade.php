<div id="produk-section" class="products-section bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Jelajahi Produk Kami</h2>

            <div class="flex items-center gap-4">
                <!-- Search Bar -->
                <input type="text" wire:model="search" placeholder="Search products..." class="px-4 py-2 border border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">

                <!-- Sorting -->
                <select wire:model="sort" class="px-4 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                    <option value="">All Products</option>
                    <option value="low-high">Price: Low to High</option>
                    <option value="high-low">Price: High to Low</option>
                    <option value="newest">Newest</option>
                </select>
            </div>
        </div>

        <!-- Products Grid -->
        @if ($produk && $produk->count() > 0)
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($produk as $p)
                <div class="product-card bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">

                        <img src="{{ asset('storage/' . $p->image) }}" alt="Product" class="w-full h-40 sm:h-48 md:h-56 object-cover rounded-t-lg">
                        <div class="p-4">
                            <h3 class="product-name text-lg font-medium text-gray-900">{{ $p->nama_produk }}</h3>
                            <p class="text-lg font-semibold text-[#fb9229]">{{ number_format($p->harga, 2, '.', ',') }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <button class="text-lg font-semibold text-[#fb9229]">
                                    <a href="{{ route('produk.detail', ['id' => $p->id]) }}">lihat detail</a>
                                </button>
                                
                                <button class="add-to-cart px-4 py-2 bg-[#FF8201] text-white rounded-lg hover:bg-[#FF8201] transition-colors">
                                    <x-cart-logo />
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Load More Button -->
            <div class="mt-8 text-center">
                <x-primary-button wire:click="loadMore" class="px-6 py-3 text-white font-semibold rounded-lg transition">
                    Load More
                </x-primary-button>
            </div>
        @else
            <div id="noResults" class="text-center py-12">
                <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                <p class="mt-2 text-gray-500">Try adjusting your search terms</p>
            </div>
        @endif
    </div>
</div>
