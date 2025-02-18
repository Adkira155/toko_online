<div class="p-5 bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Product Image Section -->
        <div class="flex justify-center items-center">
            <img src="{{$data->image}}" alt="product" class="w-[600px] h-auto rounded-lg shadow-lg object-cover">
        </div>

        <!-- Product Details Section -->
        <div class="space-y-6">
            <!-- Product Title and Rating -->
            <div>
                <h2 class="text-4xl font-semibold text-gray-800 mb-2">{{$data->nama_produk}}</h2>
                <div class="flex items-center mb-4">
                    <div class="flex gap-1 text-sm text-yellow-400">
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                        <span><i class="fa-solid fa-star"></i></span>
                    </div>
                    <div class="text-xs text-gray-500 ml-3">tersisa {{$data->stok}} produk</div>
                </div>
            </div>

            <!-- Product Information (Status, Category) -->
            <div class="space-y-2">
                <p class="text-gray-800 font-semibold">
                    <span>Status:</span>
                    <span class="text-green-600">{{$data->status}}</span>
                </p>
                <p class="text-gray-800 font-semibold">
                    <span>Kategori:</span>
                    <span class="text-gray-600">{{$data->id_kategori}}</span>
                </p>
            </div>

            <!-- Product Price -->
            <div class="flex items-baseline space-x-3 font-roboto mt-4">
                <p class="text-2xl text-primary font-semibold">Rp. {{$data->harga}}</p>
                <!-- <p class="text-base text-gray-400 line-through">$55.00</p> -->
            </div>

            <!-- Product Description -->
            <p class="mt-4 text-gray-600 text-lg">{{$data->deskripsi}}</p>

            <!-- Quantity Selection -->
            <div class="mt-6">
                <h3 class="text-sm text-gray-800 uppercase mb-2 font-semibold">Quantity</h3>
                <div class="flex items-center border border-gray-300 rounded-lg w-max" x-data="{ 
                    quantity: 1, 
                    maxQuantity: {{$data->stok}} // Set the max quantity to the available stock
                }">
                    <!-- Decrease Button -->
                    <button @click="quantity = quantity > 1 ? quantity - 1 : 1" 
                        class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none bg-gray-200 hover:bg-gray-300 rounded-l-lg">
                        -
                    </button>
                
                    <!-- Quantity Display -->
                    <div class="h-8 w-16 text-base flex items-center justify-center bg-white border-x border-gray-300">
                        <span x-text="quantity"></span>
                    </div>
                
                    <!-- Increase Button -->
                    <button @click="quantity = quantity < maxQuantity ? quantity + 1 : maxQuantity" 
                        class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none bg-gray-200 hover:bg-gray-300 rounded-r-lg">
                        +
                    </button>
                </div>
            </div>
            

            <div class="mt-6 flex gap-4 flex-col">
                <!-- Keranjang Button -->
                <a href="#" class="w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Beli
                </a>
                <!-- Beli Button -->
                <a href="#" class="w-full bg-gray-200 text-gray-700 text-center py-2 rounded-lg hover:bg-gray-300 transition duration-300">
                    Keranjang
                </a>
            </div>
        </div>
    </div>
    <div class="mt-10">
        <livewire:layout.produk-random />
    </div>
</div>
