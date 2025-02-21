<div class="bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-lg font-semibold mb-4">Daftar Produk</h2>

    <!-- tambah data -->
    <a href="{{ route('produk.create') }}" class="bg-blue-500 text-white px-2 py-1 rounded">Create</a>

    <!-- Tabel Produk -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">No</th>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Stok</th>
                    <th class="border p-2">Gambar</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produk as $item)
                <tr class="text-center">
                    <td class="border p-2">{{ $loop->iteration }}</td>
                    <td class="border p-2">{{ $item->nama_produk }}</td>
                    <td class="border p-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="border p-2">{{ $item->stok }}</td>
                    <td class="border p-2">
                        <img src="{{ asset('storage/' . $item->image) }}" class="h-16 w-auto mx-auto">
                    </td>
                    <td class="border p-2">
                        <a href="{{ route('produk.update', $item->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</a>
                        <button wire:click="hapus({{ $item->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $produk->links() }}
    </div>
</div>
