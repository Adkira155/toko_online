<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Volt\Component;

new class extends Component
{
    use WithFileUploads;

    public string $nomor = '';
    public string $alamat = '';
    public $avatar;
    public $existingAvatar;
    public $previewAvatar;

    public function mount(): void
    {
        $user = Auth::user();
        $this->nomor = $user->nomor ?? '';
        $this->alamat = $user->alamat ?? '';
        $this->existingAvatar = $user->avatar ?? null;

        if ($this->existingAvatar) {
            $this->previewAvatar = asset('storage/' . $this->existingAvatar);
        }
    }

    public function updateInfoProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'nomor' => ['required', 'string', 'max:20', 'regex:/^[0-9\-\+]+$/'],
            'alamat' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ]);

        $user->nomor = $validated['nomor'];
        $user->alamat = $validated['alamat'];

        if ($this->avatar) {
            if ($this->existingAvatar) {
                Storage::disk('public')->delete($this->existingAvatar);
            }

            $avatarPath = $this->avatar->store('avatars', 'public');
            $user->avatar = $avatarPath;

            $this->previewAvatar = asset('storage/' . $avatarPath);
            $this->existingAvatar = $avatarPath;

            $this->reset('avatar'); // Reset avatar agar cache Livewire hilang
        }

        $user->save();

        $this->existingAvatar = $user->avatar;

        $this->dispatch('profile-updated')->self();
    }

    public function updatedAvatar()
    {
        $this->previewAvatar = $this->avatar ? $this->avatar->temporaryUrl() : null;
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Detail Informasi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Berisi informasi lebih lanjut seperti Alamat, Nomor Telpon / WA untuk melengkapi profil pengguna.") }}
        </p>
    </header>

    {{-- <form wire:submit="updateInfoProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="nomor" :value="__('Nomor Telpon/WA')" />
            <x-text-input wire:model.live.lazy="nomor" id="nomor" type="text" class="mt-1 block w-full" required autofocus autocomplete="nomor" />
            <x-input-error class="mt-2" :messages="$errors->get('nomor')" />
        </div>

        <div>
            <x-input-label for="alamat" :value="__('Detail Alamat')" />
            <x-text-input wire:model="alamat" id="alamat" type="text" class="mt-1 block w-full" required autocomplete="alamat" />
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        <div>
            <x-input-label class="required" for="avatar" :value="__('Gambar Profil')" />
            <input type="file" wire:model="avatar" id="avatar" class="mt-1 block w-full">
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />

            @if ($previewAvatar)
                <img src="{{ $previewAvatar }}" class="mt-2 w-20 h-20 rounded-full" wire:loading.class="opacity-50">
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form> --}}
    <form wire:submit="updateInfoProfileInformation" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
        <!-- Avatar di kiri -->
        <div class="flex flex-col items-center space-y-3">
            @if ($previewAvatar)
                <img src="{{ $previewAvatar }}" class="w-32 h-32 rounded-full shadow-lg border-2 border-gray-300">
            @else
                <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                    No Image
                </div>
            @endif

            <input type="file" wire:model="avatar" id="avatar" class="w-full text-sm text-gray-700 border border-gray-300 rounded p-1">
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <!-- Data di kanan -->
        <div class="md:col-span-2 space-y-4">
            <div>
                <x-input-label for="nomor" :value="__('Nomor Telpon/WA')" />
                <x-text-input wire:model.live.lazy="nomor" id="nomor" type="text" class="mt-1 block w-full" required autofocus autocomplete="nomor" />
                <x-input-error class="mt-2" :messages="$errors->get('nomor')" />
            </div>

            <div>
                <x-input-label for="alamat" :value="__('Detail Alamat')" />
                <textarea wire:model="alamat" id="alamat"
                    class="mt-3 block w-full h-32 resize-none focus:ring focus:border-[#fc942c] focus:ring-[#fc942c] rounded-md shadow-md border border-gray-300 p-4"
                    required></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
            </div>
            

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </div>
    </form>

</section>
