<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function handleCallback()
    {
        try {
            // Dapatkan detail pengguna dari Google
            $googleUser = Socialite::driver('google')->user();
    
            // Cari pengguna berdasarkan email
            $existingUser = User::where('email', $googleUser->email)->first();
    
            if ($existingUser) {
                // Jika email sudah ada, perbarui provider_id (jika perlu)
                $existingUser->update([
                    'social_type' => 'google',
                    'social_id' => $googleUser->id,
                ]);
    
                // Login pengguna
                Auth::login($existingUser);

                return redirect('/dashboard');
            } else {
                $password = Str::random(10);
                // Jika email belum ada, buat akun baru
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'alamat' => '-',
                    'nomor' => 0,
                    'role' => 'user',
                    'email' => $googleUser->email,
                    'social_id' => $googleUser->id,
                    'social_type' => 'google',
                    'password' => bcrypt($password), // Password default untuk akun Google
                ]);
    
                // Login pengguna
                Auth::login($newUser);
            }
    
                return redirect('/dashboard'); // Redirect ke halaman dashboard
            }
            catch (\Exception $e) {
            return redirect('/login')->withErrors('Gagal login menggunakan Google.');
        }
    }
    
}
