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

Route::view('/produk', 'data-produk')->name('produk.data');
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
        Route::view('/home', 'admin.home');

         // ==== User ADMIN CRUD ==== //
         Route::view('/tabel-user', 'admin.tabel-user')->name('user.tabel');
         Route::view('/create-user', 'admin.user.create-user')->name('user.create');
         Route::view('/detail-user', 'admin.user.detail-user')->name('user.detail');
         Route::view('/user-update/{id}', 'admin.user.update-user')->name('user.update');

        // ==== Kategori ADMIN CU ==== //
        Route::view('/create-kategori', 'admin.kategori.create-kategori')->name('kategori.create');
        Route::view('/update-kategori/{id}', 'admin.kategori.update-kategori')->name('kategori.update');
    
        // ==== Produk ADMIN CRUD ==== //
        Route::view('/tabel-produk', 'admin.tabel-produk')->name('tabel.produk');
        Route::view('/produk-create', 'admin.produk.create-produk')->name('produk.create');
        Route::view('/produk-update/{id}', 'admin.produk.update-produk')->name('produk.update');
     
         // ==== Order ADMIN RUD ==== //\
         Route::view('/tabel-order', 'admin.tabel-order')->name('tabel.order');
         Route::view('/update-order', 'admin.order.update-order')->name('update.order');

         // ==== DetailOrder ADMIN RUD ==== //
         Route::view('/update-detailorder', 'admin.detailorder.update-detailorder')->name('update.detail-order');

         // ==== Review ADMIN Reply ==== //
        //  Route::view('/data-review', 'admin.review.data-review')->name('review.data');
    });

});

require __DIR__.'/auth.php';
