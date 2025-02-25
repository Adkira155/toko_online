<div class="bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-lg font-semibold mb-4">Daftar Produk</h2>

    <!-- tambah data -->
    <x-primary-button>
    <a href="{{ route('produk.create') }}">Tambah Produk</a>
    </x-primary-button>

    <!-- Tabel Produk -->


<div class="relative overflow-x-auto mt-5 shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama
                </th>
                <th scope="col" class="px-6 py-3">
                    Harga
                </th>
                <th scope="col" class="px-6 py-3">
                    Stok
                </th>
                <th scope="col" class="px-6 py-3">
                    Gambar
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($produk as $item)
            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $loop->iteration }}
                </th>
                <td class="px-6 py-4">
                    {{ $item->nama_produk }}
                </td>
                <td class="px-6 py-4">
                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4">
                    {{ $item->stok }}
                </td>
                <td class="px-6 py-4">
                    {{-- {{ asset('storage/' . $item->image) }} --}}
                </td>
                <td class="px-6 py-4 text-right">
                    <x-primary-button>
                        <a href="{{ route('produk.update', $item->id) }}"">Edit</a>
                    </x-primary-button>
                    <x-danger-button>
                        <a wire:click="hapusProduk({{ $item->id }})">Hapus</a>
                    </x-danger-button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


    {{-- <div class="overflow-x-auto">
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
                        <button wire:click="hapusProduk({{ $item->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}

    <!-- Pagination -->
    <div class="mt-4">
        {{ $produk->links() }}
    </div>
</div>

