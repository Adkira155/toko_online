<div id="featured-products" class="products-section bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Featured Products</h2>
            <select
                class="px-4 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                <option>All Products</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
                <option>Newest</option>
            </select>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div
                class="product-card bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                @foreach ($produk as $item)
                <img src="{{ asset('img/akidol.jpg') }}" alt="Product" class="w-full h-72 object-cover">
                <div class="p-4">
                    <h3 class="product-name text-lg font-medium text-gray-900"></h3>
                    <p class="product-description mt-1 text-sm text-gray-500">{{ $item->nama_produk }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-lg font-semibold text-[#FF8201]">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <button
                            class="add-to-cart px-4 py-2 bg-[#FF8201] text-white rounded-lg hover:bg-[#FF8201] transition-colors"> <x-cart-logo /> Keranjang 
                        </button>
                    </div>
                </div>
                @endforeach
                
            </div>

        </div>

        <!-- No Results Message -->
        <div id="noResults" class="hidden text-center py-12">
            <h3 class="text-lg font-medium text-gray-900">No products found</h3>
            <p class="mt-2 text-gray-500">Try adjusting your search terms</p>
        </div>
    </div>
</div>
