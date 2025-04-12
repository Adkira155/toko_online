<?php

namespace App\Livewire\Produk;

use App\Models\Produk;
use Livewire\Component;
use App\Models\Kategori;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ProdukPage extends Component
{
    use WithPagination;

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

    protected $updatesQueryString = ['page'];

    public function mount()
    {
        $this->kategori = Kategori::all(); //panggil kategori
    }

    // Reset ke halaman 1 saat filter berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function applyFilter()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'kategoriInputs', 'hargainputs']);
        $this->resetPage();
    }

    public function updatedKategoriInputs()
    {
        $this->resetPage();
    }

    public function updatedHargainputs()
    {
        $this->resetPage();
    }
    

    public function render()
    {
        $query = Produk::query()->where('status', 'aktif')->where('stok', '>', 0); // Jika stok 0 maka produk tidak muncul

        if (!empty($this->search)) {
            $search = trim($this->search);
            $query->where(DB::raw('lower(nama_produk)'), 'like', '%' . strtolower($search) . '%');
        }

        if (!empty($this->kategoriInputs)) {
            $query->whereIn('id_kategori', $this->kategoriInputs);
        }

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

        $produk = $query->paginate(9); // Atur jumlah per halaman
        $this->totalProduk = $produk->total();

        return view('livewire.produk.produk-page', [
            'produk' => $produk,
            'kategori' => $this->kategori,
            'hargaOptions' => $this->hargaOptions,
        ]);
    }
}