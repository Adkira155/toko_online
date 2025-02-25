<div class="bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-lg font-semibold mb-4">Daftar Order</h2>

    <!-- Tabel Order -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">No</th>
                    <th class="border p-2">Nama Produk</th>
                    <th class="border p-2">Nama Pemesan</th>
                    <th class="border p-2">Total Harga</th>
                    <th class="border p-2">Total Berat</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order as $item)
                <tr class="text-center">
                    <td class="border p-2">{{ $loop->iteration }}</td>
                    <td class="border p-2">{{$item->id_detailorder}}</td>
                    <td class="border p-2">{{$item->id_user}}</td>
                    <td class="border p-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="border p-2">{{ number_format($item->harga) }} Gram</td>
                    <td class="border p-2">{{ $item->status }}</td>
                    <td class="border p-2">
                        {{-- <a href="{{ route('order.update', $item->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</a> --}}
                        <button wire:click="hapusOrder({{ $item->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $order->links() }}
    </div>
</div>
