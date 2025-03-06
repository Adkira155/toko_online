{{-- <div>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            Notifications
            @if (session('warning'))
                <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                    Please login first to proceed with checkout
                </div>
            @endif

            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
                <a href="/" class="text-emerald-600 hover:text-emerald-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Continue Shopping
                </a>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <div class="flex-1">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden cart-items"
                        data-logged-in="{{ auth()->check() ? 'true' : 'false' }}">
                        @if ($cartItems->isEmpty())
                            <p class="p-4 text-center">Keranjang Kosong.</p>
                        @else
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="border p-2 text-left">Produk</th>
                                        <th class="border p-2 text-right">Harga</th>
                                        <th class="border p-2 text-center">Jumlah</th>
                                        <th class="border p-2 text-right">Total</th>
                                        <th class="border p-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td class="border p-2">{{ $item->produk->nama_produk }}</td>
                                            <td class="border p-2 text-right">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                            <td class="border p-2 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button wire:click="updateQuantity({{ $item->id }}, 'decrease')"
                                                        class="px-2 bg-gray-300 rounded">-</button>
                                                    <span>{{ $item->quantity }}</span>
                                                    <button wire:click="updateQuantity({{ $item->id }}, 'increase')"
                                                        class="px-2 bg-gray-300 rounded">+</button>
                                                </div>
                                            </td>
                                            <td class="border p-2 text-right">Rp {{ number_format($item->produk->harga * $item->quantity, 0, ',', '.') }}</td>
                                            <td class="border p-2 text-center">
                                                <button wire:click="removeItem({{ $item->id }})"
                                                    class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                <div class="w-full lg:w-96">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900" data-summary="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Shipping</dt>
                                <dd class="text-sm font-medium text-gray-900" data-summary="shipping">Rp {{ number_format($shipping, 0, ',', '.') }}</dd>
                            </div>
                            <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                                <dt class="text-base font-medium text-gray-900">Total</dt>
                                <dd class="text-base font-medium text-gray-900" data-summary="total">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                            </div>
                        </dl>

                        @if (auth()->check())
                            <button data-action="checkout"
                                class="mt-6 w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 px-4 rounded-lg">
                                Proceed to Checkout
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                                class="mt-6 w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 px-4 rounded-lg text-center block">
                                Login to Checkout
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div> --}}
{{-- @auth
@if(auth()->user())
    <div id="userData" data-name="{{ auth()->user()->name }}" data-phone="{{ auth()->user()->nomor }}"
        data-address="{{ auth()->user()->alamat }}" class="hidden">
    </div>
@endif
@endauth --}}

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
                            <div class="flex items-start mb-6"> <div class="w-24 h-24 mr-4">
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
                            @if (!$loop->last)
                                <hr class="my-4">
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="w-full lg:w-96 bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-4">
                    <div class="flex justify-between mb-4">
                        <span class="text-lg font-semibold text-gray-800">Total</span>
                        <span class="text-lg font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    @if (auth()->check())
                        <button data-action="checkout"
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg">
                            Proceed to Checkout
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg text-center block">
                            Login to Checkout
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>