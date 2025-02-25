<div>
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
                @foreach ($cart as $item)
                    <tr>
                        <td class="border p-2">{{ $item['nama'] }}</td>
                        <td class="border p-2">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td class="border p-2">
                            <button wire:click="updateQuantity({{ $item['id'] }}, 'decrease')" class="px-2 bg-gray-300">-</button>
                            {{ $item['quantity'] }}
                            <button wire:click="updateQuantity({{ $item['id'] }}, 'increase')" class="px-2 bg-gray-300">+</button>
                        </td>
                        <td class="border p-2">Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</td>
                        <td class="border p-2">
                            <button wire:click="removeFromCart({{ $item['id'] }})" class="bg-red-500 text-white px-2 py-1">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

