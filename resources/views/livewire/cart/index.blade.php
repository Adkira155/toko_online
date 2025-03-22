<div class="">
    <div class="bg-gray-100 min-h-screen">
        <div class="container mx-auto py-10 px-4">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold text-gray-800">Keranjang Belanja</h1>
                <a href="/" class="text-orange-600 hover:text-orange-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Lanjut Belanja
                </a>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="flex-1 bg-white rounded-lg shadow p-6">
                    @if ($cartItems->isEmpty())
                        <p class="text-center text-gray-600 py-10">Keranjang Kosong.</p>
                    @else
                        @foreach ($cartItems as $item)
                        <div class="">
                            <div class="flex items-start mb-6 ">
                                <div class="w-24 h-24 mr-4">
                                    <img src="{{ $item->produk->image ? url('storage/' . $item->produk->image) : asset('images/default.png') }}" alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-cover rounded">
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-lg font-semibold text-gray-800">{{ $item->produk->nama_produk }}</h2>
                                    <p class="text-sm text-gray-600">{{ $item->produk->deskripsi }}</p>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-lg font-semibold text-gray-800">Rp {{ number_format($item->produk->harga * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center">
                                    <button wire:click="updateQuantity({{ $item->id }}, 'decrease')" class="px-3 py-1 bg-gray-200 rounded mr-2">-</button>
                                    <span class="mx-2">{{ $item->quantity }}</span>
                                    <button wire:click="updateQuantity({{ $item->id }}, 'increase')" class="px-3 py-1 bg-gray-200 rounded ml-2">+</button>
                                </div>
                                <button wire:click="removeItem({{ $item->id }})" class="text-gray-500 hover:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                            @if (!$loop->last)
                                <hr class="my-4">
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="lg:w-96 bg-white rounded-lg shadow p-6 h-full">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h2>

                    @foreach ($cartItems as $item)
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">{{ $item->produk->nama_produk }} ({{ $item->quantity }}x)</span>
                            <span class="font-semibold">Rp {{ number_format($item->produk->harga * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    <hr class="my-4">

                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if (count($cartItems) > 0 )
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Admin</span>
                        <span class="font-semibold">Rp {{ number_format($admin, 0, ',', '.') }}</span>
                    </div>
                    
                    <hr class="my-4">
                    <div class="flex justify-between mb-4">
                        <span class="text-lg font-semibold text-gray-800">Total</span>
                        <span class="text-lg font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="flex flex-col lg:flex-row gap-8">
                        @if (count($cartItems) > 0)
                            @if (auth()->check())
                                <button wire:click="showCheckoutForm" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg">
                                   Proses Ke Pemesanan
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg text-center block">
                                    Login to Checkout
                                </a>
                            @endif
                        @else
                            <p class="text-red-500">Keranjang Anda kosong.</p>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Informasi Shippping dan Ringkasan --}}
            <div class="mt-5 flex flex-col lg:flex-row gap-8">

                @if ($showCheckout)
                <div class="flex-1 bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Shipping</h2>
            
                    {{-- bawaan data user --}}
                    <div class="mb-2">
                        <p><span class="font-semibold">Nomor Telpon/WA:</span> {{ $nomorTelepon }}</p>
                        <p><span class="font-semibold">Alamat Lengkap:</span> {{ $alamat }}</p>
            
                        @if ($id_provinsi)
                            <p><span class="font-semibold">Provinsi:</span>
                                {{ collect($provinces)->where('id', $id_provinsi)->first()['name'] ?? 'Tidak Diketahui' }}
                            </p>
                        @else
                            <p class="text-red-500 text-sm">⚠ Provinsi harus diisi.</p>
                        @endif
                        @if ($id_kota)
                            <p><span class="font-semibold">Kota:</span>
                                {{ collect($cities)->where('id', $id_kota)->first()['name'] ?? 'Tidak Diketahui' }}
                            </p>
                        @else
                            <p class="text-red-500 text-sm">⚠ Kota harus diisi.</p>
                        @endif
                    </div>
            
                    {{-- input data  --}}
            
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Isi Data Berikut</h2>
            
                    <div class="mb-4">
                        <x-input-label for="namaPenerima" :value="__('Nama Penerima')" />
                        <x-text-input id="namaPenerima" wire:model="namaPenerima" class="mt-1 block w-full" type="text" required />
                        @error('namaPenerima') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
            
                    <div class="mb-4">
                        <x-input-label for="catatan" :value="__('Catatan Untuk Kurir (Opsional)')" />
                        <textarea id="catatan" wire:model="catatan" class="block mt-1 w-full p-2 shadow-lg rounded-md border border-gray-300 appearance-none resize-y" rows="3"></textarea>
                        @error('catatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
            
                    {{-- Form Pilih Ekspedisi --}}
                    <div class="mb-4">
                        <x-input-label for="courier" :value="__('Pilih Ekspedisi')" />
                        <div class="relative">
                            <select wire:model="courier" class="mt-1 mb-3 block w-full p-2 shadow-lg rounded-md border border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-4 py-2 appearance-none bg-white">
                                <option value="">Pilih Expedisi</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">TiKi</option>
                                <option value="spx">Shopee Express</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="jnt">J&T Express</option>
                                <option value="sicepat">SiCepat</option>
                                <option value="tiki">TiKi</option>
                                <option value="anteraja">AnterAja</option>
                                <option value="wahana">Wahana Express</option>
                                <option value="ninja">Ninja Express</option>
                                <option value="lion">Lion Parcel</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7-7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('courier') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
            
                    <button wire:click="submitData" class="mt-1 w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg">
                        Submit Data
                    </button>
                    <p class="text-sm text-gray-500 mt-4">
                        *Pastikan data pengiriman sudah benar, jika ingin melakukan perubahan,
                        <a href="/profile" class="text-blue-600">klik di sini</a>
                    </p>
                </div>
                @endif

                {{-- Muncul ketika submit data admin --}}
                @if ($showRingkasan)
                <form wire:submit.prevent="checkout">
                    <div class="w-full lg:w-96 bg-white rounded-lg shadow p-6">

                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>
                    
                        {{-- Daftar Item (Produk) --}}
                        @foreach ($cartItems as $item)
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">{{ $item->produk->nama_produk }} ({{ $item->quantity }}x)</span>
                                <span class="font-semibold">Rp {{ number_format($item->produk->harga * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    
                        <hr class="my-4">
                    
                        {{-- Subtotal --}}
                        <div class="flex justify-between mb-4">
                            <span class="text-lg font-semibold text-gray-800">Total</span>
                            <span class="text-lg font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    
                        {{-- Biaya Admin --}}
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Admin</span>
                            <span class="font-semibold">Rp {{ number_format($admin, 0, ',', '.') }}</span>
                        </div>
                    
                        {{-- Ongkos Kirim --}}
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-semibold">
                                Rp {{ number_format($ongkir, 0, ',', '.') }}
                            </span>
                        </div>
                    
                        <hr class="my-4">
                    
                        {{-- Total --}} 
                        <div class="flex justify-between mb-4">
                            <span class="text-lg font-semibold text-gray-800">Total</span>
                            <span class="text-lg font-semibold">
                                Rp {{ number_format($totalHarga, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between mb-4">
                            <span class="text-lg font-semibold text-gray-800">Total Berat</span>
                            <span class="text-lg font-semibold">{{ $totalBerat }} Gram</span> 
                        </div>
                    
                        {{-- Informasi Pengiriman --}}
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengiriman</h2>
                    
                        <div>
                            <div>
                                <div class="mb-2">
                                    <p><span class="font-semibold">Provinsi Asal:</span> {{ $provinsiAsalName ?? 'Tidak Diketahui' }}</p>
                                    <p><span class="font-semibold">Kota Asal:</span> {{ $kotaAsalName ?? 'Tidak Diketahui' }}</p>
                                    <hr class="my-4">
                                </div>
                            </div>
                        </div>
                    
                        <div class="mb-2">
                            <p><span class="font-semibold">Nomor Telepon/WhatsApp:</span>{{ $nomorTelepon }}</p>
                            <p><span class="font-semibold">Provinsi Tujuan:</span>{{ collect($provinces)->where('id', $id_provinsi)->first()['name'] ?? 'Tidak Diketahui' }}</p>
                            <p><span class="font-semibold">Kota Tujuan:</span>{{ collect($cities)->where('id', $id_kota)->first()['name'] ?? 'Tidak Diketahui' }}</p>
                            <p><span class="font-semibold">Alamat Lengkap:</span>{{ $alamat }}</p>
                            <p><span class="font-semibold">Ekspedisi:</span>{{$courier}}</p>
                            <hr class="my-4">
                        </div>
                    
                        {{-- Informasi Penerima --}}
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Penerima</h2>
                    
                        <div class="mb-2">
                            <p><span class="font-semibold">Nama Penerima:</span>{{ $namaPenerima }}</p>
                            <p><span class="font-semibold">Catatan untuk Kurir:</span>{{ $catatan }}</p>
                        </div>
                    
                        {{-- Tombol Checkout menuju Midtrans --}}
                        <div class="flex flex-col lg:flex-row gap-8">

                            <button wire:click="checkout" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg">
                               Checkout Sekarang
                             </button> 
                            {{-- <a href="{{ route('checkout') }}" 
                               class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg text-center">
                                Checkout Sekarang
                            </a> --}}
                        </div>
                        
                        <p class="text-sm text-gray-500 mt-4">*Periksa kembali pesanan Anda sebelum melanjutkan pembayaran.</p>

                         {{-- notif --}}
                         @if ($pesanSukses)
                         <div class="bg-green-500 text-white px-4 py-2 rounded-md mb-3">
                             {{ $pesanSukses }}
                         </div>
                     @endif
                    </div>
                </form>
                @endif

            </div>
          
            
        </div>
    </div>
</div>