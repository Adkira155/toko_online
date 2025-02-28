<div class="bg-white px-5 py-16">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Dropdown Filter (Mobile & Tablet) - Dihilangkan dari Mobile & Tablet -->
        <div class="hidden md:hidden w-full">
            <button id="filterToggle" class="w-full bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded">
                Filter Produk ▼
            </button>
            <div id="filterDropdown" class="hidden mt-2 bg-white p-4 rounded-lg shadow-md w-full border border-gray-300">
                <h3 class="text-lg font-semibold mb-3">Filters</h3>

                <!-- Filter Harga -->
                <div class="mb-4">
                    <h4 class="text-md font-medium">Harga</h4>
                    <ul class="text-gray-700 text-sm mt-2">
                        <li><input type="checkbox" class="mr-2"> Less than 50</li>
                        <li><input type="checkbox" class="mr-2"> From 50 to 100</li>
                        <li><input type="checkbox" class="mr-2" checked> From 100 to 500</li>
                        <li><input type="checkbox" class="mr-2"> More than 500</li>
                    </ul>
                </div>

                <!-- Filter Kategori -->
                <div class="mb-4">
                    <h4 class="text-md font-medium">Kategori</h4>
                    <ul class="text-gray-700 text-sm mt-2">
                        <li><input type="checkbox" class="mr-2"> A consectetur.</li>
                        <li><input type="checkbox" class="mr-2"> At sed re magnam.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar Filter (Desktop) - Hanya Tampil di Desktop -->
        <aside class="hidden md:block col-span-1 bg-gray-100 p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-3">Filters</h3>

            <!-- Filter Harga -->
            <div class="mb-4">
                <h4 class="text-md font-medium">Harga</h4>
                <ul class="text-gray-700 text-sm mt-2">
                    <li><input type="checkbox" class="mr-2"> Less than 50</li>
                    <li><input type="checkbox" class="mr-2"> From 50 to 100</li>
                    <li><input type="checkbox" class="mr-2" checked> From 100 to 500</li>
                    <li><input type="checkbox" class="mr-2"> More than 500</li>
                </ul>
            </div>

            <!-- Filter Kategori -->
            <div class="mb-4">
                <h4 class="text-md font-medium">Kategori</h4>
                <ul class="text-gray-700 text-sm mt-2">
                    <li><input type="checkbox" class="mr-2"> A consectetur.</li>
                    <li><input type="checkbox" class="mr-2"> At sed re magnam.</li>
                </ul>
            </div>
        </aside>

        <!-- Products Grid -->
<div class="col-span-3">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @foreach ($random as $r)
        <div class="bg-white border border-gray-300 shadow-md rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
            <a href="{{ url('/produk-detail/' . $r->id) }}" class="block">
                <img src="{{ $r->image ? asset($r->image) : asset('images/default.png') }}" 
                     alt="Product Image" 
                     class="h-48 w-full object-cover rounded-t-xl" />
                <div class="p-4">
                    <h2 class="text-lg font-bold text-gray-800 truncate">{{ $r->nama_produk }}</h2>

                    <!-- Menampilkan kategori dengan benar -->
                    <span class="bg-blue-200 text-blue-600 text-xs uppercase px-2 py-1 rounded">
                        {{ is_iterable($r->kategoris) ? implode(", ", array_map(fn($k) => $k->nama, $r->kategoris->toArray())) : ($r->kategoris->nama ?? "-") }}
                    </span>

                    <p class="text-gray-500 text-sm mt-2 truncate">{{ $r->deskripsi }}</p>
                    <p class="text-lg font-semibold text-gray-900 mt-3">Rp. {{ number_format($r->harga, 0, ',', '.') }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
    </div>
</div>

<!-- Script untuk Dropdown -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var filterToggle = document.getElementById('filterToggle');
        var filterDropdown = document.getElementById('filterDropdown');

        filterToggle.addEventListener('click', function () {
            filterDropdown.classList.toggle('hidden');
        });

        // Klik di luar untuk menutup dropdown
        document.addEventListener('click', function (event) {
            if (!filterToggle.contains(event.target) && !filterDropdown.contains(event.target)) {
                filterDropdown.classList.add('hidden');
            }
        });
    });
</script> 