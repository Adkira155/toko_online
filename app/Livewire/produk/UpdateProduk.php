<?php

namespace App\Livewire\Produk;

use App\Models\Kategori;
use App\Models\produk;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

class UpdateProduk extends Component
{
    
    use WithFileUploads;
    use WithPagination;

    #[Validate('max:10240')] 
    public $nama_produk, $harga, $berat, $stok, $image, $kategori, $deskripsi, $status;
    public $id_kategori;
    public $id_produk;
    public $cekImage;
    public $id;
    public $produk;
    

    public function mount($id) {
        $this->produk = Produk::FindOrFail($id);
       
        $this->id_produk = $this->produk->id; 
        $this->nama_produk = $this->produk->nama_produk;
        $this->harga = $this->produk->harga;
        $this->deskripsi = $this->produk->deskripsi;
        $this->stok = $this->produk->stok;
        $this->berat = $this->produk->berat;
        $this->cekImage = $this->produk->image; 
        $this->id_kategori = $this->produk->id_kategori;
        $this->status = $this->produk->status;
        
        $this->kategori = Kategori::all(); 
    }

    public function update() {

            $this->validate([
                'nama_produk' => ['required'],
                'kategori' => ['required'],
                'deskripsi' => ['required'],
                'harga' => ['required'],
                'stok' => ['required', 'integer'],
                'berat' => ['required', 'integer'], 
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
                'status' => ['required'],
            ]);
        
            $produk = Produk::findOrFail($this->id_produk); 
        
            if ($this->image) {
                if ($this->cekImage) {
                    Storage::disk('public')->delete($this->cekImage); 
                }
                $imageName = $this->image->store('images', 'public');
            } else {
                $imageName = $this->cekImage;
            }
        
            // Update data produk
            $produk->update([
                'nama_produk' => $this->nama_produk,
                'id_kategori' => $this->id_kategori, // Simpan hanya ID kategori
                'deskripsi' => $this->deskripsi,
                'harga' => $this->harga,
                'stok' => $this->stok,
                'berat' => $this->berat,
                'status' => $this->status,
                'image' => $imageName,
            ]);
        
            session()->flash('message', 'Produk berhasil diperbarui!');
            return redirect()->route('produk.update', $this->id_produk); 
    }

    public function render()
    {
        return view('livewire.produk.update-produk');
    }
}