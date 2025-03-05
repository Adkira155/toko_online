<div>
<div class="bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-lg font-semibold mb-4">Daftar Produk</h2>

    <!-- tambah data -->
    <x-primary-button>
    <span class="text-lg font-bold">+</span>
    <a href="{{ route('produk.create') }}">Tambah Produk</a>
    </x-primary-button>

     <!-- Pencarian & Filter -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mt-4 space-y-2 md:space-y-0">
        <!-- Input Pencarian -->
        <input 
            type="text" 
            wire:model.defer="tempSearch" 
            class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" 
            placeholder="Cari produk...">
        
        <!-- Filter Status -->
        <select wire:model.defer="tempFilterStatus" class="w-full md:w-1/4 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="tidak aktif">Tidak Aktif</option>
        </select>

        <!-- Tombol Filter -->
        <x-primary-button wire:click="applyFilter">
            Cari / Filter
        </x-primary-button>
    </div>
    
    <!-- Tabel Produk -->
<div class="relative overflow-x-auto mt-5 shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dat-table">
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
                    Berat
                </th>
                <th scope="col" class="px-6 py-3">
                    Gambar
                </th>
                <th scope="col" class="px-6 py-3">
                   Status Produk
                </th>
                <th scope="col" class="px-6 py-3">
                   Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($produk as $item)
            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $loop->iteration }}
                </td>
                <td class="px-6 py-4">
                    {{ $item->nama_produk }}
                </td>
                <td class="px-6 py-4">
                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4">
                    {{ $item->stok }} 
                    <span class="badge {{ $item->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                       / {{ $item->stok > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    {{ $item->berat ? $item->berat . ' Gram' : '0 Gram' }}
                </td>
                <td class="px-6 py-4">
                    <img class="size-12 lg:size-20" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->image }}">
                </td>

                <td>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:click="toggleStatus({{ $item->id }})"
                               class="sr-only peer" 
                               @checked($item->status === 'aktif')>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600">
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-5"></div>
                        </div>
                    </label>
                </td>

                <td class="px-6 py-4 text-right">
                    <!-- Detail -->
                    <button wire:click="showProduct({{ $item->id }})"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Lihat Detail
                </button>

                    {{-- edit --}}
                    <x-primary-button>
                        <a href="{{ route('produk.update', $item->id) }}">Edit</a>
                    </x-primary-button>
                    
                    {{-- hapus --}}
                    <x-danger-button>
                        <a wire:click="hapusProduk({{ $item->id }})">Hapus</a>
                    </x-danger-button>
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

    <!-- Main modal -->
    @if ($selectedProduk)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Detail Produk</h2>

            <img class="w-full h-40 object-cover rounded" 
                 src="{{ asset('storage/' . $selectedProduk->image) }}" 
                 alt="{{ $selectedProduk->nama_produk }}">

            <h3 class="text-xl font-bold mt-2">{{ $selectedProduk->nama_produk }}</h3>
            <h3 class="text-gray-600">{{ $selectedProduk->deskripsi }}</h3>
            <p class="text-gray-600">Harga: Rp {{ number_format($selectedProduk->harga, 0, ',', '.') }}</p>
            <p class="text-gray-600">Berat: {{ $selectedProduk->berat ? $item->berat . ' Gram' : '0 Gram' }}</p>
            <p class="text-gray-600">Stok: {{ $selectedProduk->stok }}</p>
            <p class="text-gray-600">Status: 
                <span class="{{ $selectedProduk->status == 'aktif' ? 'text-green-600' : 'text-red-600' }}">
                    {{ ucfirst($selectedProduk->status) }}
                </span>
            </p>

            <!-- Tombol Tutup -->
            <button wire:click="closeModal"
                    class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Tutup
            </button>
            <a href="{{ route('review.create', $selectedProduk->id) }}" 
                class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                <span class="text-lg font-bold">+</span>
                <span class="font-semibold">Lihat Review</span>
            </a>
        </div>
    </div>
@endif


</div>
</div>

    @script
    <script>
        $(document).ready(function() {
            var table = $('.dat-table').DataTable({
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();
        });
    </script>
    @endscript

</div>