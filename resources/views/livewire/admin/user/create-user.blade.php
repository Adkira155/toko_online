<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="text-slate-700 py-4 px-4">
        Buat User
    </div>
    <hr />
    <form wire:submit="create">
        <div class="p-4 grid lg:grid-cols-2 gap-4">
            <div class="grid gap-4">
                <div>
                    <x-input-label class="required" for="name" :value="__('Nama Pengguna')" />
                    <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" value="{{$name}}"
                        required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label class="required" for="email" :value="__('Email')" />
                    <x-text-input wire:model="email" id="email" name="email" type="text" class="mt-1 block w-full" value="{{$email}}"
                        required autofocus autocomplete="email" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label class="required" for="nomor" :value="__('nomor')" />
                    <x-text-input wire:model="nomor" id="nomor" name="nomor" type="number" class="mt-1 block w-full" value="{{$nomor}}"
                        required autofocus autocomplete="nomor" />
                    <x-input-error class="mt-2" :messages="$errors->get('nomor')" />
                </div>

                <div>
                    <x-input-label class="required" for="role" :value="__('role')" />
                    <x-text-input wire:model="role" id="role" name="role" type="text" class="mt-1 block w-full" value="{{$role}}"
                        required autofocus autocomplete="role" />
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>

                <div>
                    <x-input-label class="required" for="password" :value="__('password')" />
                    <x-text-input wire:model="password" id="password" name="password" type="password" class="mt-1 block w-full" value="{{$password}}"
                        required autofocus autocomplete="password" />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>
                
            </div>
        </div>
        <div class="p-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            <x-primary-button wire:click="back()">{{ __('Kembali') }}</x-primary-button>
        </div>
    </form>
</div>
