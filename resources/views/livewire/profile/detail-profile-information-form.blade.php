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

    <form wire:submit="updateInfoProfileInformation" class="mt-6 space-y-6">
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
    </form>
</section>
