<div class="bg-blue-200 py-5">
    <div class=" grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-5 py-8">
        @foreach ($produks as $p )
        <div class="bg-white shadow-md rounded-xl hover:scale-105 hover:shadow-lg transition-transform duration-300">
            <a href="{{ route('produk.detail', ['id' => $p->id]) }}" wire:navigate>
                <img src="{{$p->image}}" alt="Product 1" class="h-60 w-full object-cover rounded-t-xl" />
                <div class="px-4 py-3">
                    <h2 class="text-lg font-bold text-black truncate">{{$p->nama_produk}}</h2>
                    <span class="bg-blue-200 text-blue-600 text-xs uppercase p-1 rounded">{{$p->kategoris->nama}}</span>
                    <p class="text-gray-400 text-sm uppercase mt-2">{{$p->deskripsi}}</p>
                    <p class="text-lg font-semibold text-black my-3">Rp. {{ number_format($p->harga, 0, ',', '.') }}</p>
            </a>
                    <div class="flex gap-3 mt-4">
                        <a href="#" class="w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                            Keranjang
                        </a>
                        <a href="#" class="w-full bg-gray-200 text-gray-700 text-center py-2 rounded-lg hover:bg-gray-300 transition duration-300">
                            Beli
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4 flex justify-center">
        {{ $produks->links() }}
    </div>
</div>