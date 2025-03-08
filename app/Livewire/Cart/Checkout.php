<?php

namespace App\Livewire\Cart;

use App\Services\BinderbyteService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component
{
    public $namaPenerima;
    public $nomorTelepon;
    public $alamat;
    public $catatan;
    public $provinces;
    public $cities;
    public $id_provinsi;
    public $id_kota;
    public $nama_kota;

    public function mount()
    {
        $user = Auth::user();
        if ($user) {
            $this->namaPenerima = $user->name;
            $this->nomorTelepon = $user->nomor;
            $this->alamat = $user->alamat;
            $this->id_provinsi = $user->id_provinsi;
            $this->id_kota = $user->id_kota;
            $this->nama_kota = $user->nama_kota;

            $binderbyteService = app(BinderbyteService::class);
            $this->provinces = $binderbyteService->getProvinces();
            // Ambil data kota jika id_provinsi tersedia
            if ($this->id_provinsi) {
                $binderbyteService = app(BinderbyteService::class);
                $this->cities = $binderbyteService->getCities($this->id_provinsi);
            }
        }
        // dd($this->all());
    }

    public function render()
    {
        return view('livewire.cart.checkout');
    }
}