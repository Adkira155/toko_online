<div class="">
    <div class="p-4 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Ringkasan Pesanan</h2>
    
        <div class="mb-2">
            <strong>Nama Penerima:</strong> 
        </div> 
    
        <div class="mb-2">
            <strong>Nomor Telepon:</strong> 
        </div>
    
        <div class="mb-2">
            <strong>Alamat:</strong>
        </div>
    
        <div class="mb-2">
            <strong>Kurir:</strong> 
        </div>
    
        <div class="mb-2">
            <strong>Catatan:</strong>
        </div>
    
        <h3 class="text-lg font-bold mt-4">Detail Produk</h3>
        <table class="w-full border-collapse border border-gray-300 mt-2">
            <thead>
                <tr>
                    <th class="border border-gray-300 p-2">Produk</th>
                    <th class="border border-gray-300 p-2">Harga</th>
                    <th class="border border-gray-300 p-2">Kuantitas</th>
                    <th class="border border-gray-300 p-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"></td>
                </tr>
              
            </tbody>
        </table>
    
        <div class="mt-4">
            <strong>Total Harga:</strong> 
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <button type="submit" id="pay-button" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-lg">
                Bayar
            </button>
        </div>
    
        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
                Kembali ke Beranda
            </a>
        </div>
    </div>
    
</div>