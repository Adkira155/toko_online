<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="text-slate-700 py-4 px-4">
        Tambah Pengguna
    </div>
    <hr />
    <form wire:submit="create">
        <div class="p-4 grid lg:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="grid gap-4">
                <div>
                    <x-input-label class="required" for="username" :value="__('Nama')" />
                    <x-text-input wire:model="username" id="username" name="username" type="text" 
                        class="mt-1 block w-full" required autofocus autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                </div>

                <div>
                    <x-input-label class="required" for="email" :value="__('Email')" />
                    <x-text-input wire:model="email" id="email" name="email" type="text"
                        class="mt-1 block w-full" required autocomplete="email" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                
                <div>
                    <x-input-label class="required" for="role" :value="__('role')" />
                    <x-text-input wire:model="role" id="role" name="role" type="text"
                    class="mt-1 block w-full" required autocomplete="role" />
                <x-input-error class="mt-2" :messages="$errors->get('role')" />
                    {{-- <select wire:model="role" id="role" name="role" class="mt-1 block w-full" required>
                        <option value="">Pilih Role</option>
                        @foreach($role as $u)
                            <option value="{{ $u->id }}">{{ $u->role}}</option>
                        @endforeach
                    </select> --}}
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>
               
            </div>
    
            <!-- Kolom Kanan -->
            <div class="grid gap-4">
                <div>
                    <x-input-label class="required" for="password" :value="__('password')" />
                    <x-text-input wire:model="password" id="password" name="password" type="text"
                        class="mt-1 block w-full" required autocomplete="password" />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                {{-- <div>
                    <x-input-label class="required" for="image" :value="__('Avatar')" />
                    <x-text-input wire:model="image" id="image" name="image" type="file" 
                        class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                </div> --}}
            </div>
        </div>
    
        <!-- Tombol Simpan & Kembali -->
        <div class="p-4 flex justify-end space-x-4">
            <button class="btn btn-primary btn-sm">Kirim</button>
            <x-primary-button wire:click="back()">{{ __('Kembali') }}</x-primary-button>
        </div>
    </form>
    
</div>

