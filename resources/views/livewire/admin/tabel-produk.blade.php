<div>
<div class="bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-lg font-semibold mb-4">Daftar Produk</h2>

    <!-- tambah data -->
    <x-primary-button>
    <span class="font-bold">+</span>
    <a href="{{ route('produk.create') }}">Tambah Produk</a>
    </x-primary-button>

    @if (session()->has('message'))
    <div x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 50000)"
        x-show="show"
        class="p-4 mb-4 text-sm text-white bg-red-500 rounded-lg shadow-md">
        {{ session('message') }}
    </div>
@endif



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
<div class="hidden md:block overflow-x-auto w-full mt-5">
    <table class="w-full text-xs md:text-sm text-left text-gray-500 whitespace-nowrap">
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
                    <img class="max-w-[60px] h-auto rounded-md" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->image }}">
                </td>
                    {{-- <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:click="toggleStatus({{ $item->id }})"
                               class="sr-only peer" 
                               @checked($item->status === 'aktif')>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600">
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-5"></div>
                        </div>
                    </label> --}}

                    {{-- <label class="relative inline-flex cursor-pointer items-center">
                        <input id="switch" type="checkbox" class="peer sr-only" wire:click="toggleStatus({{ $item->id }})" @checked($item->status === 'aktif') />
                        
                        <label for="switch" class="hidden"></label>
                        <div class="peer h-6 w-11 rounded-full border bg-slate-200 after:absolute after:left-[2px] after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-slate-800 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:ring-green-300"></div>
                      </label> --}}

                      <td class="px-6 py-4 text-center">
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input id="switch" type="checkbox" class="peer sr-only" 
                                wire:click="toggleStatus({{ $item->id }})" 
                                @checked($item->status === 'aktif') />
                            
                            <label for="switch" class="hidden"></label>
                            <div class="peer h-5 w-9 rounded-full border bg-slate-200 
                                after:absolute after:left-[2px] after:top-0.5 
                                after:h-4 after:w-4 after:rounded-full after:border 
                                after:border-gray-300 after:bg-white after:transition-all 
                                after:content-[''] peer-checked:bg-green-500 
                                peer-checked:after:translate-x-4 peer-checked:after:border-white">
                            </div>
                        </label>
                    </td>

                <td class="px-6 py-4 text-right">
                    <!-- Detail -->
                    <x-secondary-button wire:click="showProduct({{ $item->id }})"
                        class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                    Lihat Detail
                </x-secondary-button>

                    {{-- edit --}}
                    <x-primary-button>
                        <a href="{{ route('produk.update', $item->id) }}" class="px-5 font-bold">Edit</a>
                    </x-primary-button>
                    
                    {{-- hapus --}}
                <x-danger-button class="px-6 py-2"
                    x-data
                    @click="Swal.fire({
                    title: 'Apakah Anda Yakin?',
                     text: 'Produk akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('konfirmasiHapus', [{{ $item->id }}]);
                    }
                    })">
                    Hapus
                </x-danger-button>

                
                
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Tampilan Kartu untuk Mobile -->
<div class="block md:hidden space-y-4">
    @foreach($produk as $item)
    <div class="bg-white shadow-md rounded-lg p-4">
        <h3 class="text-lg font-semibold">{{ $item->nama_produk }}</h3>
        <p>Harga: Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
        <p>Stok: {{ $item->stok }}</p>
        <p>Berat: {{ $item->berat }} Gram</p>
        <p class="flex items-center gap-2">Status: 
            <td class="px-6 py-4 text-center">
                <label class="relative inline-flex cursor-pointer items-center">
                    <input id="switch-{{ $item->id }}" type="checkbox" class="peer sr-only"
                        wire:click="toggleStatus({{ $item->id }})"
                        @checked($item->status === 'aktif') />
                    
                    <label for="switch-{{ $item->id }}" class="hidden"></label>
                    <div class="peer h-5 w-9 rounded-full border bg-slate-200 
                    relative after:absolute after:left-[2px] after:top-0.5 
                    after:h-4 after:w-4 after:rounded-full after:border 
                    after:border-gray-300 after:bg-white after:transition-all 
                    after:content-[''] peer-checked:bg-green-500 
                    peer-checked:after:translate-x-4 peer-checked:after:border-white">
                    </div>

                </label>
            </td>
        </p>
        <img class="max-w-[100px] h-auto rounded-md mt-2" 
             src="{{ asset('storage/' . $item->image) }}" 
             alt="{{ $item->image }}">
        <div class="mt-2">
            <x-secondary-button wire:click="showProduct({{ $item->id }})"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 mt-2">
                Lihat Detail
            </x-secondary-button>            
            <x-primary-button>
                <a href="{{ route('produk.update', $item->id) }}" class="px-5 font-bold">Edit</a>
            </x-primary-button>
            <x-danger-button class="px-6 py-2"
                    x-data
                    @click="Swal.fire({
                    title: 'Apakah Anda Yakin?',
                     text: 'Produk akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('konfirmasiHapus', [{{ $item->id }}]);
                    }
                    })">
                    Hapus
                </x-danger-button>
        </div>
    </div>
    @endforeach
</div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $produk->links() }}
    </div>

    <!-- Main modal -->
    @if ($selectedProduk)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl max-h-[90vh]">
            <h2 class="text-lg font-semibold mb-4">Detail Produk</h2>
    
            <div class="grid grid-cols-2 gap-4">
                <img class="w-full h-auto object-cover rounded" 
                     src="{{ asset('storage/' . $selectedProduk->image) }}" 
                     alt="{{ $selectedProduk->nama_produk }}">
    
                <div class="space-y-2">
                    <h3 class="text-xl font-bold">{{ $selectedProduk->nama_produk }}</h3>
                    <p class="text-gray-600 truncate" title="{{ $selectedProduk->deskripsi }}">
                        {{ Str::limit($selectedProduk->deskripsi, 150, '...') }}
                    </p>
                    <p class="text-gray-600">Harga: Rp {{ number_format($selectedProduk->harga, 0, ',', '.') }}</p>
                    <p class="text-gray-600">Berat: {{ $selectedProduk->berat ? $selectedProduk->berat . ' Gram' : '0 Gram' }}</p>
                    <p class="text-gray-600">Stok: {{ $selectedProduk->stok }}</p>
                    <p class="text-gray-600">Status: 
                        <span class="{{ $selectedProduk->status == 'aktif' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($selectedProduk->status) }}
                        </span>
                    </p>
                </div>
            </div>
    
            <div class="flex justify-between mt-4">
                <button wire:click="closeModal"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Tutup
                </button>
                <a href="{{ route('review.create', $selectedProduk->id) }}" 
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Lihat Review
                </a>
            </div>
        </div>
    </div>
    
@endif
</div>
</div>

   <!-- DataTable -->
<script>
 document.addEventListener("DOMContentLoaded", function() {
    var table = $('.dat-table').DataTable({
        responsive: true,
        scrollX: true, // Tambahkan scrollbar horizontal jika tabel lebar
        autoWidth: false,
        columnDefs: [
            { targets: [5, 6, 7], orderable: false }, // Nonaktifkan sorting pada kolom tertentu
            { targets: '_all', className: 'text-left' } // Pastikan teks tetap rata kiri
        ],
        language: {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ditemukan data yang sesuai",
            "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(Difilter dari _MAX_ total data)",
            "search": "Cari:",
            "paginate": {
                "first": "Awal",
                "last": "Akhir",
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            }
        }
    }).columns.adjust().responsive.recalc();
});

document.addEventListener("DOMContentLoaded", function() {
    var table = $('.dat-table').DataTable({
        responsive: true,
        scrollX: false, // Hapus scrollbar jika layout card lebih baik
        autoWidth: false,
        columnDefs: [
            { targets: [4, 5, 6], visible: false }, // Sembunyikan kolom yang tidak terlalu penting di mobile
            { targets: '_all', className: 'text-left' }
        ]
    }).columns.adjust().responsive.recalc();
});

</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('swal', function(e) {
        Swal.fire({
            title: e.detail.title || 'Berhasil!',
            text: e.detail.text || 'Produk berhasil dihapus.',
            icon: e.detail.icon || 'success',
            timer: e.detail.timer || 3000
        });
    });
</script>

<!-- Pastikan Alpine.js sudah dimuat -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


</div>