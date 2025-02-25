<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="text-slate-700 py-4 px-4">
        Buat Produk
    </div>
    <hr />
    <form wire:submit="create">
        <div class="p-4 grid lg:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="grid gap-4">
                <div>
                    <x-input-label class="required" for="nama_produk" :value="__('Nama Produk')" />
                    <x-text-input wire:model="nama_produk" id="nama_produk" name="nama_produk" type="text" 
                        class="mt-1 block w-full" required autofocus autocomplete="nama_produk" />
                    <x-input-error class="mt-2" :messages="$errors->get('nama_produk')" />
                </div>
                
                <div>
                    <x-input-label class="required" for="kategori" :value="__('Kategori')" />
                    <select wire:model="kategori" id="kategori" name="kategori" class="mt-1 block w-full" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($id_kategori as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama}}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('kategori')" />
                </div>
                <div>
                    <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                    <x-text-input wire:model="deskripsi" id="deskripsi" class="block mt-1 w-full" type="text"
                        name="deskripsi" required autocomplete="deskripsi" />
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>
                <div>
                    <x-input-label class="required" for="harga" :value="__('Harga')" />
                    <x-text-input wire:model="harga" id="harga" name="harga" type="text"
                        class="mt-1 block w-full" required autocomplete="harga" />
                    <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                </div>
            </div>
    
            <!-- Kolom Kanan -->
            <div class="grid gap-4">
                <div>
                    <x-input-label class="required" for="berat" :value="__('Berat')" />
                    <x-text-input wire:model="berat" id="berat" name="berat" type="number"
                        class="mt-1 block w-full" required autocomplete="berat" />
                    <x-input-error class="mt-2" :messages="$errors->get('berat')" />
                </div>
                <div>
                    <x-input-label class="required" for="stok" :value="__('Stok')" />
                    <x-text-input wire:model="stok" id="stok" name="stok" type="number"
                        class="mt-1 block w-full" required autocomplete="stok" />
                    <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                </div>

                <div>
                    <x-input-label class="required" for="image" :value="__('Gambar Produk')" />
                    <x-text-input wire:model="image" id="image" name="image" type="file" 
                        class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div>
            </div>
        </div>
    
        <!-- Tombol Simpan & Kembali -->
        <div class="p-4 flex justify-end space-x-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            <x-primary-button wire:click="back()">{{ __('Kembali') }}</x-primary-button>
        </div>
    </form>
    
</div>
