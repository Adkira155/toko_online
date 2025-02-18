<div class="bg-white px-5 py-16">
    <div class="flex justify-center mb-5">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">Jelajahi Produk Pilihan Kami</h2>
    </div>

    <div x-data="{
        currentIndex: 0,
        products: [
            @foreach ($random as $r)
                {
                    img: '{{ $r->image }}',
                    name: '{{ $r->nama_produk }}',
                    description: '{{ $r->deskripsi }}',
                    id_produk: '{{ $r->id }}',
                    price: 'Rp. {{ number_format($r->harga, 0, ',', '.') }}',
                    kategori: '{{ $r->kategoris->nama }}',
                },
            @endforeach
        ],
        get visibleCards() {
            return window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
        },
        get maxIndex() {
            return Math.ceil(this.products.length / this.visibleCards) - 1;
        },
        getProductUrl(id) {
            return '/produk-detail/' + id; // Generate URL for each product
        }
    }">
        <div class="relative w-full overflow-hidden">
            <div class="flex transition-transform duration-500 gap-2 md:gap-5"
                :style="{ transform: `translateX(-${currentIndex * 100 / visibleCards}%)` }">
                <template x-for="(product, index) in products" :key="index">
                    <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0">
                        <div class="bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl mx-auto">
                            <!-- Use Alpine.js to generate the href -->
                            <a :href="getProductUrl(product.id_produk)" wire:navigate>
                                <img :src="product.img" alt="Product" class="h-80 w-full object-cover rounded-t-xl" />
                                <div class="px-4 py-3">
                                    <h2 class="text-lg font-bold text-black truncate" x-text="product.name"></h2>
                                    <span class="bg-blue-200 text-blue-600 text-xs uppercase p-1 rounded" x-text="product.kategori"></span>
                                    <p class="text-gray-400 text-xs uppercase mt-2" x-text="product.description"></p>
                                    <p class="text-lg font-semibold text-black my-3" x-text="product.price"></p>
                                </div>
                            </a>
                        </div>
                    </div>
                </template>
            </div>

            <br>
            <!-- Tombol Navigasi -->
            <button @click="currentIndex = currentIndex > 0 ? currentIndex - 1 : maxIndex"
                class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-2 rounded-full">
                &#10094;
            </button>
            <button @click="currentIndex = currentIndex < maxIndex ? currentIndex + 1 : 0"
                class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-2 rounded-full">
                &#10095;
            </button>
        </div>
    </div>
</div>
