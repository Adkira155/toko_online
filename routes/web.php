<?php

use App\Http\Middleware\admin;
use App\Livewire\Layout\About;
use App\Http\Middleware\pengunjung;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::view('dashboard', 'dashboard')
->middleware(['auth', 'verified'])
->name('dashboard');

Route::view('profile', 'profile')
->middleware(['auth'])
->name('profile');

/*
|--------------------------------------------------------------------------
| ================= GUEST / PUBLIC ROUTE ================= 
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('callback/google', [GoogleController::class, 'handleCallback']);  
Route::view('/', 'dashboard');


Route::view('/tentang', 'tentang')->name('tentang');

Route::view('/produk', 'data-produk')->name('produk.data');
Route::view('/produk-page', 'user.produk-page')->name('produk.page');
Route::view('/produk-detail/{id}', 'admin.produk.detail-produk')->name('produk.detail');
Route::view('/review-create/{produk_id}', 'admin.review.create-review')->name('review.create');


Route::middleware(['auth'])->group(function () {  
     
/*
|--------------------------------------------------------------------------
| ================= PENGUNJUNG ROUTE ================= 
|--------------------------------------------------------------------------
*/
    Route::middleware([pengunjung::class])->group(function () {

    Route::view('/keranjang', 'user.cart.keranjang')->name('user.keranjang');
    Route::view('/checkout', 'user.checkout')->name('checkout');
    Route::view('/Riwayat-Pemesanan', 'user.riwayat-status')->name('status');
      
        //Di Pengunjung punya halaman keranjang, create keranjang, lalu checkout
        //bayar, lihat status transaksi punya dia dan melihat detail transaksi, user bisa membuat review
    });

/*
|--------------------------------------------------------------------------
| ================= ADMIN ROUTE ================= 
|--------------------------------------------------------------------------
*/
    Route::middleware([admin::class])->group(function () {

        // ==== DASHBOARD ADMIN ==== //
        Route::view('/home', 'admin.home')->name('admin.home');
        Route::view('/dashboard-admin', 'admin.dashboard-admin')->name('admin.dashboard');

        //  ==== User ADMIN CRUD ==== //
        //  Route::view('/tabel-user', 'admin.tabel-user')->name('user.tabel');
        //  Route::view('/create-user', 'admin.user.create-user')->name('user.create');
        //  Route::view('/detail-user', 'admin.user.detail-user')->name('user.detail');
        //  Route::view('/user-update/{id}', 'admin.user.update-user')->name('user.update');

        // ==== Kategori ADMIN CU ==== //
        Route::view('/create-kategori', 'admin.kategori.create-kategori')->name('kategori.create');
        Route::view('/update-kategori/{id}', 'admin.kategori.update-kategori')->name('kategori.update');
    
        // ==== Produk ADMIN CRUD ==== //
        Route::view('/tabel-produk', 'admin.tabel-produk')->name('tabel.produk');
        Route::view('/produk-create', 'admin.produk.create-produk')->name('produk.create');
        Route::view('/produk-update/{id}', 'admin.produk.update-produk')->name('produk.update');
     
         // ==== Order ADMIN RUD ==== //\
         Route::view('/tabel-order', 'admin.tabel-order')->name('tabel.order');
         Route::view('/tabel-riwayat', 'admin.tabel-riwayat')->name('tabel.riwayat');
         Route::view('/update-order', 'admin.order.update-order')->name('update.order');

         // ==== Review ADMIN Reply ==== //
        //  Route::view('/data-review', 'admin.review.data-review')->name('review.data');

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');
    

        
    });

});

require __DIR__.'/auth.php';
