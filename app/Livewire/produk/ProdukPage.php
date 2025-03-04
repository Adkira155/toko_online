<?php
namespace App\Livewire\Produk;

use Livewire\Component;
use App\Models\Produk;
use App\Models\Kategori;

class ProdukPage extends Component
{
    public $produk;
    public $kategori;
    public $kategoriInputs = [];
    public $hargainputs = [];
    public $search = '';

    public $hargaOptions = [
        'under_25000' => 'Dibawah 25.000',
        '25000_50000' => 'Dari 25.000 sampai 50.000',
        '50000_100000' => 'Dari 50.000 sampai 100.000',
        'above_100000' => 'Lebih dari 100.000',
    ];

    public function mount()
    {
        $this->kategori = Kategori::all();
        $this->produk = Produk::all(); // Menampilkan semua produk awalnya
    }

    public function applyFilter()
    {
        $this->searchProduk(); //Penerapan pencarian dan filter
    }

    public function searchProduk()
    {
        $query = Produk::query();

        // Filter Nama Produk
        if (!empty($this->search)) {
            $query->where('nama_produk', 'like', '%' . $this->search . '%');
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
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->kategoriInputs = [];
        $this->hargainputs = [];
        $this->produk = Produk::all();
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
