<?php
namespace App\Livewire\Produk;

use App\Models\Produk;
use Livewire\Component;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class ProdukPage extends Component
{
    public $produk;
    public $kategori;
    public $kategoriInputs = [];
    public $hargainputs = [];
    public $search = '';
    public $totalProduk;

    public $hargaOptions = [
        'under_25000' => 'Dibawah 25.000',
        '25000_50000' => 'Dari 25.000 sampai 50.000',
        '50000_100000' => 'Dari 50.000 sampai 100.000',
        'above_100000' => 'Lebih dari 100.000',
    ];

    public function mount()
    {
        $this->kategori = Kategori::all(); //menampilkan semua kategori
        $this->produk = Produk::inRandomOrder()->get(); // Menampilkan semua prodk

        $this->totalProduk = Produk::count();
    }

    public function applyFilter()
    {
        $this->searchProduk(); //pencarian
    }

    public function updatedSearch()
    {
        $this->searchProduk();
    }

    public function searchProduk()
    {
        $query = Produk::query();

        // Filter Nama Produk
        if (!empty($this->search)) {
            $search = trim($this->search);
            $query->where(DB::raw('lower(nama_produk)'), 'like', '%' . strtolower($search) . '%')
                  ->limit(12);
        }

        //kategori
        if (!empty($this->kategoriInputs)) {
            $query->whereIn('id_kategori', $this->kategoriInputs);
        }

       //harga
        if (!empty($this->hargainputs)) {
            $query->where(function ($q) {
                foreach ($this->hargainputs as $filter) {
                    if ($filter == 'under_25000') {
                        $q->orWhere('harga', '<', 25000);
                    } elseif ($filter == '25000_50000') {
                        $q->orWhereBetween('harga', [25000, 50000]);
                    } elseif ($filter == '50000_100000') {
                        $q->orWhereBetween('harga', [50000, 100000]);
                    } elseif ($filter == 'above_100000') {
                        $q->orWhere('harga', '>', 100000);
                    }
                }
            });
        }

        $this->produk = $query->get();

        // Hitung jumlah produk setelah filter
        $this->totalProduk = $query->count();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->kategoriInputs = [];
        $this->hargainputs = [];
        $this->produk = Produk::all();
        $this->totalProduk = Produk::count(); 
    }

    public function render()
    {
        return view('livewire.produk.produk-page', [
            'produk' => $this->produk,
            'kategori' => $this->kategori,
            'hargaOptions' => $this->hargaOptions,
        ]);
    }
}