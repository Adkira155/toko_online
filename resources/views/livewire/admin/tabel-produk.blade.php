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
                    
                    <x-secondary-button data-modal-target="default-modal" data-modal-toggle="default-modal">
                        Detail
                    </x-secondary-button>

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
</div>

{{-- <!-- Modal -->
@if($showModal)
<div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-semibold mb-4">Detail Produk</h2>

        @if($selectedProduk)
        <p><strong>Nama:</strong> {{ $selectedProduk->nama_produk }}</p>
        <p><strong>Harga:</strong> Rp {{ number_format($selectedProduk->harga, 0, ',', '.') }}</p>
        <p><strong>Stok:</strong> {{ $selectedProduk->stok }}</p>
        <p><strong>Berat:</strong> {{ $selectedProduk->berat }} Gram</p>
        <img src="{{ asset('storage/' . $selectedProduk->image) }}" class="w-full h-40 object-cover mt-2 rounded-lg">
        @endif

        <button wire:click="closeModal" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg">
            Tutup
        </button>
    </div>
</div>
@endif
</div> --}}

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

    <!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white shadow-sm border border-black">
            <div class="p-5 bg-white">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <!-- Product Image Section -->
                    <div class="flex justify-center items-center">
                        <img src="{{asset('img/akira.png')}}" alt="product" class="w-[600px] h-auto rounded-lg shadow-lg object-cover">
                    </div>
            
                    <!-- Product Details Section -->
                    <div class="space-y-6">
                        <!-- Product Title and Rating -->
                        <div>
                            <h2 class="text-4xl font-semibold text-gray-800 mb-2">Barang siapa</h2>
                            <div class="flex items-center mb-4">
                                <div class="flex gap-1 text-sm text-yellow-400">
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                    <span><i class="fa-solid fa-star"></i></span>
                                </div>
                                <div class="text-xs text-gray-500 ml-3">tersisa .. produk</div>
                            </div>
                        </div>
            
                        <!-- Product Information (Status, Category) -->
                        <div class="space-y-2">
                            <p class="text-gray-800 font-semibold">
                                <span>Status:</span>
                                <span class="text-green-600"></span>
                            </p>
                            <p class="text-gray-800 font-semibold">
                                <span>Kategori:</span>
                                <span class="text-gray-600"></span>
                            </p>
                        </div>
            
                        <!-- Product Price -->
                        <div class="flex items-baseline space-x-3 font-roboto mt-4">
                            <p class="text-2xl text-primary font-semibold">Rp. </p>
                            <!-- <p class="text-base text-gray-400 line-through">$55.00</p> -->
                        </div>
            
                        <!-- Product Description -->
                        <p class="mt-4 text-gray-600 text-lg"></p>
            
                        <!-- Quantity Selection -->
                        <div class="mt-6">
                            <h3 class="text-sm text-gray-800 uppercase mb-2 font-semibold">Quantity</h3>
                            <div class="flex items-center border border-gray-300 rounded-lg w-max" x-data="{ 
                                quantity: 1, 
                                maxQuantity:  // Set the max quantity to the available stock
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
            
                            <a href="" class="w-full bg-gray-200 text-gray-700 text-center py-2 rounded-lg hover:bg-gray-300 transition duration-300">
                                review
                            </a>
                            
            
                        </div>
                    </div>
                </div>
            </div>
        </div>
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