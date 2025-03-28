<div class="p-5 bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Product Image Section -->
        <div class="flex justify-center items-center">
            <img src="{{ asset('storage/' . $data->image) }}" alt="product" class="w-[600px] h-auto rounded-lg shadow-lg object-cover">
        </div>

        <!-- Product Details Section -->
        <div class="space-y-6">
            <!-- Product Title and Rating -->
            <div>
                <h2 class="text-4xl font-semibold text-gray-800 mb-2">{{$data->nama_produk}}</h2>
                <div class="flex items-center mb-4">
                    
                    <div class="text-xs text-gray-500">tersisa {{$data->stok}} produk</div>
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
                    <span class="text-gray-600">{{$data->kategoris->nama ?? 'Tidak ada kategori'}}</span>
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
            {{-- <div class="mt-6">
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
            </div> --}}

            <div class="mt-6">
                <h3 class="text-sm text-gray-800 uppercase mb-2 font-semibold">Quantity</h3>
                <div class="flex items-center border border-gray-300 rounded-lg w-max">
                    <!-- Decrease Button -->
                    <button wire:click="decreaseQuantity" 
                        class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none bg-gray-200 hover:bg-gray-300 rounded-l-lg">
                        -
                    </button>
                
                    <!-- Quantity Display -->
                    <div class="h-8 w-16 text-base flex items-center justify-center bg-white border-x border-gray-300">
                        {{ $quantityCount }}
                    </div>
                
                    <!-- Increase Button -->
                    <button wire:click="increaseQuantity" 
                        class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none bg-gray-200 hover:bg-gray-300 rounded-r-lg">
                        +
                    </button>
                </div>
            </div>
            

            <div class="mt-6 flex gap-4 flex-col">
                <button wire:click="addToCart({{ $data->id }})" 
                    class="inline-flex max-w-max bg-gray-200 text-gray-700 px-5 py-2 rounded-lg items-center space-x-2 hover:bg-gray-300 transition duration-300">
                    <x-cart-logo class="w-5 h-5" /> 
                    <span>Masukkan Keranjang</span>
                </button>

                <!-- Menampilkan pesan error jika ada -->
                @if ($errorMessage)
                    <div class="bg-red-500 text-white px-4 py-2 rounded-md mb-3">
                        {{ $errorMessage }}
                    </div>
                @endif

                <!-- Menampilkan pesan sukses jika ada -->
                @if ($successMessage)
                    <div class="bg-green-500 text-white px-4 py-2 rounded-md mb-3">
                        {{ $successMessage }}
                    </div>
                @endif
            </div>

        </div>
    </div>

 <livewire:layout.review-pengguna :id="$id" />
  
 <div class="flex justify-end">
    <a href="{{ route('review.create', $data->id) }}" 
        class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
       
        <span class="font-semibold">Tambah Review</span>
    </a>
</div>
</div>
</div>
</div>
</div>

    {{-- <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    
        <h2 class="text-xl font-semibold mb-4">Review Pengguna</h2>
        
        <div class="space-y-4">
            <div class="p-4 border rounded-lg bg-white shadow-md flex items-center space-x-3">
                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                    <span class="text-gray-600 text-sm">U1</span>
                </div>
                <div>
                    <p class="font-bold text-gray-900">User1</p>
                    <p class="text-gray-700">Produk ini sangat bagus! Saya sangat puas.</p>
                </div>
            </div>
            <div class="p-4 border rounded-lg bg-white shadow-md flex items-center space-x-3">
                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                    <span class="text-gray-600 text-sm">U2</span>
                </div>
                <div>
                    <p class="font-bold text-gray-900">User2</p>
                    <p class="text-gray-700">Kualitasnya sesuai dengan harga, pengiriman cepat.</p>
                </div>
            </div>
        </div>
        
        
        
    </div> --}}
    
</div>