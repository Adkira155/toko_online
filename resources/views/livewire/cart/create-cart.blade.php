<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-lg font-bold mb-3">Keranjang Belanja</h3>

        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(empty($cart))
            <p class="text-gray-500">Keranjang kosong.</p>
        @else
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border p-2">Produk</th>
                        <th class="border p-2">Harga</th>
                        <th class="border p-2">Jumlah</th>
                        <th class="border p-2">Total</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $id => $item)
                        <tr>
                            <td class="border p-2">{{ $item['id_produk'] }}</td>
                            <td class="border p-2">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td class="border p-2">
                                <button wire:click="updateQuantity({{ $id }}, 'decrease')" class="px-2 bg-gray-300">-</button>
                                {{ $item['quantity'] }}
                                <button wire:click="updateQuantity({{ $id }}, 'increase')" class="px-2 bg-gray-300">+</button>
                            </td>
                            <td class="border p-2">Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</td>
                            <td class="border p-2">
                                <button wire:click="removeFromCart({{ $id }})" class="bg-red-500 text-white px-2 py-1">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Order Summary -->
        <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium text-gray-900">Ringkasan Pesanan</h2>
            <dl class="mt-4 space-y-4">
                <div class="flex items-center justify-between">
                    <dt class="text-sm text-gray-600">Subtotal</dt>
                    <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-sm text-gray-600">Pengiriman</dt>
                    <dd class="text-sm font-medium text-gray-900">Rp 10.000</dd>
                </div>
                <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                    <dt class="text-base font-medium text-gray-900">Total</dt>
                    <dd class="text-base font-medium text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                </div>
            </dl>
            
            <button class="mt-6 w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 px-4 rounded-lg">
                Checkout
            </button>
        </div>
    </div>
</div>
