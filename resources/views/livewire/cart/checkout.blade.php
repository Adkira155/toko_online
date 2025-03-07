<div class="mt-10 bg-white rounded-lg shadow p-6">
  <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Shipping</h2>

  {{-- bawaan data user --}}
  <div class="mb-2">
    <p>Nomor Telp/WA: {{ $nomorTelepon }}</p>
    <p>Alamat: {{ $alamat }}</p>
  </div>

  {{-- input data  --}}

  <h2 class="text-lg font-semibold text-gray-800 mb-4">Isi Data Berikut</h2>

    <div class="mb-4">
      <x-input-label for="namaPenerima" :value="__('Nama Penerima')" />
      <x-text-input 
          id="namaPenerima" 
          wire:model="namaPenerima" 
          class="mt-1 block w-full" 
          type="text" 
          required 
      />
  </div>

  <div class="mb-4">
    <x-input-label for="catatan" :value="__('Catatan (Opsional)')" />
    <textarea 
        id="catatan" 
        wire:model="catatan" 
        class="block mt-1 w-full p-2 shadow-lg rounded-md border border-gray-300 appearance-none resize-y"
        rows="3"
    ></textarea>
</div>

<p class="text-sm text-gray-500 mt-4">
    *Pastikan data pengiriman sudah benar, jika ingin melakukan perubahan, 
    <a href="/profile" class="text-blue-600">klik di sini</a>
</p>
</div>