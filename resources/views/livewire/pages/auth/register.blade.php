<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $alamat = '';
    public string $role = 'user';
    public ?int $nomor = null;
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'nomor' => ['required', 'integer'],
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 mb-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Alamat -->
        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <x-text-input wire:model="alamat" id="alamat" class="block mt-1 w-full" type="text" name="alamat" required autofocus autocomplete="alamat" />
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>

        <!-- nomor -->
        <div>
            <x-input-label for="nomor" :value="__('Nomor Telepon/Whatsapp')" />
            <x-text-input wire:model="nomor" id="nomor" class="block mt-1 w-full" type="text" name="nomor" required autofocus autocomplete="nomor" />
            <x-input-error :messages="$errors->get('nomor')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        

        <div class="flex items-center justify-between mt-4">
            
            <x-primary-button class="w-full mt-2 py-3 text-white text-center font-bold rounded-lg transition-all duration-300 flex items-center justify-center">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-6 text-sm text-gray-600 flex justify-between">
            <p class="mt-4">
                <a href="/" class="border-b border-gray-500 border-dotted">Kembali</a>
            </p>
            <p class="mt-4">
                Sudah punya akun? <a href="/login" class="border-b border-gray-500 border-dotted">Masuk</a>
            </p>
        </div>
    </form>
</div>
