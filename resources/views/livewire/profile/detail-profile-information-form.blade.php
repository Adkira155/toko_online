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

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->nomor = $user->nomor ?? '';
        $this->alamat = $user->alamat ?? '';
        $this->existingAvatar = $user->avatar ?? null;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateInfoProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'nomor' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ]);

        $user->nomor = $validated['nomor'];
        $user->alamat = $validated['alamat'];

        // Jika ada gambar baru, hapus gambar lama dan simpan gambar baru
        if ($this->avatar) {
            if ($this->existingAvatar) {
                Storage::disk('public')->delete($this->existingAvatar);
            }

            $avatarPath = $this->avatar->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        // Update existingAvatar agar tetap sinkron di frontend
        $this->existingAvatar = $user->avatar;

        $this->dispatch('profile-updated');
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
            <x-text-input wire:model="nomor" id="nomor" type="text" class="mt-1 block w-full" required autofocus autocomplete="nomor" />
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

            <!-- Preview avatar jika ada -->
            @if ($existingAvatar)
                <img src="{{ asset('storage/' . $existingAvatar) }}" class="mt-2 w-20 h-20 rounded-full">
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
