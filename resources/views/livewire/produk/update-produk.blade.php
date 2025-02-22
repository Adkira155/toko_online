<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="text-slate-700 py-4 px-4">
        Edit Produk
        {{-- {{$produk}} --}}
    </div>
    <hr />
     <form wire:submit="update">
        <div class="p-4 grid lg:grid-cols-2 gap-4">
            <div class="grid gap-4">
                <div>
                    <x-input-label class="required" for="nama_produk" :value="__('nama_produk Produk')" />
                    <x-text-input wire:model="nama_produk" id="nama_produk" name="nama_produk" type="text" class="mt-1 block w-full" value="{{$produk->nama_produk}}"
                        required autofocus autocomplete="nama_produk"  />
                    <x-input-error class="mt-2" :messages="$errors->get('nama_produk')" />
                </div>
                <div>
                    <x-input-label class="required" for="image" :value="__('Gambar Produk')" />
                    <x-text-input wire:model="image" id="image" name="image" type="file" class="mt-1 block w-full"
                        required autofocus autocomplete="image" value="{{$produk->image}}"/>
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>

                <div class="mt-4">
                    <x-input-label class="required" for="kategori" :value="__('Kategori')" />
                    <select wire:model="kategori" id="kategori" name="kategori" class="mt-1 block w-full" required>
                        <option value="">Pilih Kategori</option>
                         @foreach($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    
                    @endforeach
                    </select>  
                    <x-input-error class="mt-2" :messages="$errors->get('kategori')" />
                </div>

                <div>
                    <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                    <x-text-input wire:model="deskripsi" id="deskripsi" class="block mt-1 w-full" type="text"
                        name="deskripsi" required autocomplete="deskripsi" value="{{$deskripsi}}"/>
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>
                <div>
                    <x-input-label class="required" for="harga" :value="__('Harga')" />
                    <x-text-input wire:model="harga" id="harga" name="harga" type="number"
                        class="mt-1 block w-full" required autocomplete="harga" value="{{$harga}}" />
                    <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                </div>

                <div>
                    <x-input-label class="required" for="berat" :value="__('berat')" />
                    <x-text-input wire:model="berat" id="berat" name="berat" type="number"
                        class="mt-1 block w-full" required autocomplete="berat" value="{{$berat}}"/>
                    <x-input-error class="mt-2" :messages="$errors->get('berat')" />
                </div>

                <div>
                    <x-input-label class="required" for="stok" :value="__('Stok')" />
                    <x-text-input wire:model="stok" id="stok" name="stok" type="number"
                        class="mt-1 block w-full" required autocomplete="stok" value="{{$stok}}"/>
                    <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                </div>

                <div>
                    <x-input-label class="required" for="status" :value="__('status')" />
                    <x-text-input wire:model="status" id="status" name="status" type="text"
                        class="mt-1 block w-full" required autocomplete="status" value="{{$status}}"/>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>
            </div>
        </div>
        <div class="p-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
            <x-primary-button wire:click="back()">{{ __('Kembali') }}</x-primary-button>
        </div>
    </form> 
</div>
