<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Middleware\admin;
use App\Http\Middleware\pengunjung;


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


Route::view('/produk', 'produk.data-produk')->name('produk.data');
Route::view('/produk-detail/{id}', 'produk.detail-produk')->name('produk.detail');


Route::middleware(['auth'])->group(function () {   
/*
|--------------------------------------------------------------------------
| ================= PENGUNJUNG ROUTE ================= 
|--------------------------------------------------------------------------
*/

    Route::middleware([pengunjung::class])->group(function () {

        Route::view('/keranjang', 'user.keranjang')->name('user.keranjang');

    });

/*
|--------------------------------------------------------------------------
| ================= ADMIN ROUTE ================= 
|--------------------------------------------------------------------------
*/

    Route::middleware([admin::class])->group(function () {
        // ==== DASHBOARD ADMIN ==== //
        Route::view('/home', 'home');

        // ==== Kategori ADMIN ==== //
        Route::view('/data-kategori', 'kategori.data-kategori')->name('kategori.data');
        Route::view('/create-kategori', 'kategori.create-kategori')->name('kategori.create');
        Route::view('/update-kategori/{id}', 'kategori.update-kategori')->name('kategori.update');
    
        // ==== Produk ADMIN ==== //
        Route::view('/produk-create', 'produk.create-produk')->name('produk.create');
        Route::view('/produk-update', 'produk.update-produk')->name('produk.update');
    });



});

require __DIR__.'/auth.php';
