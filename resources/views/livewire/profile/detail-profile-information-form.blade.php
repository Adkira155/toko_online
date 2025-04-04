<?php

use App\Models\User;
use App\Services\BinderbyteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Volt\Component;
use Illuminate\Validation\Rule;

new class extends Component
{
    use WithFileUploads;

    public string $nomor = '';
    public string $alamat = '';
    public $avatar;
    public $existingAvatar;
    public $previewAvatar;
    public array $provinces = [];
    public array $cities = [];
    public ?string $id_provinsi = null;
    public ?string $id_kota = null;

        public function mount(): void
    {
        $binderbyteService = app(BinderbyteService::class);

        $user = Auth::user();
        $this->nomor = $user->nomor ?? '';
        $this->alamat = $user->alamat ?? '';
        $this->existingAvatar = $user->avatar ?? null;
        $this->id_provinsi = $user->id_provinsi ? (string) $user->id_provinsi : null;
        $this->id_kota = $user->id_kota ? (string) $user->id_kota : null;

        if ($this->existingAvatar) {
            $this->previewAvatar = asset('storage/' . $this->existingAvatar);
        }

        $this->provinces = $binderbyteService->getProvinces();
        

        if ($this->id_provinsi) {
            $this->cities = $binderbyteService->getCities($this->id_provinsi);
        }
    }


    public function updateInfoProfileInformation(): void
    {
        $binderbyteService = app(BinderbyteService::class);

        $validated = $this->validate([
            'nomor' => ['required', 'string', 'max:20', 'regex:/^[0-9\-\+]+$/'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120', 'dimensions:min_width=100,min_height=100'],
            'id_provinsi' => ['required', Rule::in(array_map(fn($p) => (string) $p['id'], $this->provinces))],
            'id_kota' => ['required', Rule::in(array_map(fn($c) => (string) $c['id'], $this->cities))],
            'alamat' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/\b(rt|rw)\b/i', $value)) {
                        $fail('Alamat harus menyertakan RT, RW dan Nomor Rumah.');
                    }
                },
            ],
        ]);

        $user = Auth::user();
        $user->fill($validated);

        if ($this->avatar && $this->avatar->isValid()) {
            if ($this->existingAvatar && Storage::disk('public')->exists($this->existingAvatar)) {
                Storage::disk('public')->delete($this->existingAvatar);
            }

            $avatarPath = $this->avatar->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $this->previewAvatar = asset('storage/' . $avatarPath);
            $this->existingAvatar = $avatarPath;

            $this->reset('avatar');
        }

        $user->save();

        // Flash message untuk notifikasi
        session()->flash('message', 'Profil berhasil diperbarui.');

        // Refresh agar data baru muncul
        $this->mount();
        $this->dispatch('profile-updated')->self();
    }



    public function updatedAvatar()
    {
        if ($this->avatar && $this->avatar->isValid()) {
            $this->previewAvatar = $this->avatar->temporaryUrl();
        } else {
            $this->previewAvatar = null;
        }
    }

    public function updatedIdProvinsi()
    {
    $binderbyteService = app(BinderbyteService::class);

    if ($this->id_provinsi) {
        $this->cities = $binderbyteService->getCities($this->id_provinsi);
    } else {
        $this->cities = [];
        $this->id_kota = null;
    }
    }
};
?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Detail Informasi') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Berisi informasi lebih lanjut seperti Alamat, Nomor Telpon / WA untuk melengkapi profil pengguna.") }}
        </p>
    </header>

    <form wire:submit.prevent="updateInfoProfileInformation" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
        <div class="flex flex-col items-center space-y-3">
            @if ($previewAvatar)
                <img src="{{ $previewAvatar }}" class="w-32 h-32 rounded-full shadow-lg border-2 border-gray-300">
            @else
                <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                    No Image
                </div>
            @endif

            <input type="file" wire:model="avatar" id="avatar" class="w-full text-sm text-gray-700 border border-gray-300 rounded p-1">
            <div wire:loading wire:target="avatar" class="text-sm text-gray-500">Uploading...</div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="md:col-span-2 space-y-3">

            <div>
                <x-input-label for="id_provinsi" :value="__('Provinsi')" />
                <select wire:model="id_provinsi" id="id_provinsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="" disabled selected>Pilih Provinsi</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province['id'] ?? '' }}">{{ $province['name'] ?? 'Tidak Diketahui' }}</option>
                    @endforeach
                </select>
                <div wire:loading wire:target="id_provinsi" class="text-sm text-gray-500">Memuat Kota...</div>
                <x-input-error class="mt-2" :messages="$errors->get('id_provinsi')" />
            
                @if ($id_provinsi)
                    <div class="mt-4">
                        <x-input-label for="id_kota" :value="__('Kota')" />
                        <select wire:model="id_kota" id="id_kota" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="" disabled selected>Pilih Kota</option>
                            @if ($cities)
                                @foreach ($cities as $city)
                                    <option value="{{ $city['id'] ?? '' }}">{{ $city['name'] ?? 'Tidak Diketahui' }}</option>
                                @endforeach
                            @endif
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('id_kota')" />
                    </div>
                @endif
            </div>
            
            <div>
                <x-input-label for="alamat" :value="__('Detail Alamat')" />
                <textarea wire:model="alamat" id="alamat" class="mt-3 block w-full h-32 resize-none rounded-md shadow-md border border-gray-300 p-4" required></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
            </div>

            <div>
                <x-input-label for="nomor" :value="__('Nomor Telpon/WA')" />
                <x-text-input wire:model.live.lazy="nomor" id="nomor" type="text" class="mt-1 block w-full" required autofocus autocomplete="nomor" />
                <x-input-error class="mt-2" :messages="$errors->get('nomor')" />
            </div>
         
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                    @if (session()->has('message'))
                        <div x-data="{ show: true }" 
                            x-show="show" 
                            x-init="setTimeout(() => show = false, 3000)" 
                            class="text-orange-700 text-sm">
                            {{ session('message') }}
                        </div>
                    @endif
            </div>
        </div>
    </form>
</section>
