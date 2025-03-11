<div class="bg-white px-5">
    <!-- 🔎 Search Bar -->
    <div class="mb-6 flex items-center">
        <input type="text" wire:model.debounce.500ms="search" placeholder="Cari produk..."
        class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
    
        <button wire:click="searchProduk" 
            class="ml-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">
            Cari
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <aside class="hidden md:block col-span-1 bg-gray-100 p-4 rounded-lg h-96">
            <h3 class="text-lg font-semibold mb-3">Filters</h3>
    
            <div class="mb-4">
                <h4 class="text-md font-medium">Harga</h4>
                <ul class="text-gray-700 text-sm mt-2">
                    @foreach ($hargaOptions as $key => $label)
                        <li>
                            <input type="checkbox" class="mr-2" wire:model="hargainputs" value="{{ $key }}">
                            {{ $label }}
                        </li>
                    @endforeach
                </ul>
            </div>
    
            <div class="mb-4">
                <h4 class="text-md font-medium">Kategori</h4>
                <ul class="text-gray-700 text-sm mt-2">
                    @foreach ($kategori as $kat)
                        <li>
                            <input type="checkbox" class="mr-2" wire:model="kategoriInputs" value="{{ $kat->id }}">
                            {{ $kat->nama }}
                        </li>
                    @endforeach
                </ul>
            </div>
    
            <button wire:click="applyFilter" class="px-4 py-2 bg-softoren text-white rounded-lg mt-3 w-full active:scale-95 transition-transform duration-200">
                Terapkan Filter
            </button>
    
            <button wire:click="resetFilters" 
                class="px-4 py-2 bg-softred text-white rounded-lg mt-3 w-full active:scale-95 transition-transform duration-200"
                id="resetFilterButton">
                Reset Filter
            </button>
    
        </aside>
    
        <div class="col-span-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($produk as $r)
                    <div class="product-card bg-white overflow-hidden shadow-sm rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg" wire:key="product-{{ $r->id }}">
                        <a href="{{ url('/produk-detail/' . $r->id) }}" class="block">
                            <img src="{{ $r->image ? asset('storage/' . $r->image) : asset('images/default.png') }}" alt="{{ $r->nama_produk }}"
                                class="w-full h-40 sm:h-48 md:h-56 object-cover rounded-t-lg" />
                            <div class="p-4">
                                <h2 class="text-lg font-bold text-gray-800 truncate">{{ $r->nama_produk }}</h2>
    
                                <span class="bg-softoren text-white text-xs uppercase px-2 py-1 rounded">
                                    {{ $r->kategoris->nama ?? '-' }}
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
