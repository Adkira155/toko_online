<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Notifications\ResetPasswordNotification;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // Temukan pengguna berdasarkan email
        $user = \App\Models\User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.');
            return;
        }

        // Buat token reset password
        $token = Str::random(64);

        // Simpan token di tabel password_resets
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $this->email],
            [
                'email' => $this->email,
                'token' => bcrypt($token),
                'created_at' => now(),
            ],
        );

        // Kirim notifikasi kustom
        $user->notify(new ResetPasswordNotification($this->email));

        $this->reset('email');
        session()->flash('status', 'Kami telah mengirimkan tautan reset password ke email Anda.');
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Lupa kata sandi? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang kata sandi yang memungkinkan Anda memilih kata sandi baru.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Kirim Tautan Reset Kata Sandi') }}
            </x-primary-button>
        </div>
    </form>
</div>
