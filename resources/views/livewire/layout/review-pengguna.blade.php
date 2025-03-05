<div>
    <div class="bg-gray-100 py-10 flex justify-center mt-16">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-3xl">
            <h2 class="text-xl font-semibold mb-4 text-center">Review Pengguna</h2>
    
            <div class="space-y-4">
                <div class="p-6 border rounded-lg bg-white shadow-lg flex items-center space-x-6 relative">
                    <img class="w-14 h-14 rounded-full" src="{{ asset('img/akira.png') }}" alt="Profile picture">
                    <div class="flex-1">
                        <p class="font-bold text-gray-900">Akira <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span></p>
                        <p class="text-gray-700 mt-1">Produknya bagus bgt omg</p>
                    </div>
                </div>
    
                <div class="p-6 border rounded-lg bg-white shadow-lg flex items-center space-x-6 relative">
                    <img class="w-14 h-14 rounded-full" src="{{ asset('img/user2.png') }}" alt="Profile picture">
                    <div class="flex-1">
                        <p class="font-bold text-gray-900">User2 <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span></p>
                        <p class="text-gray-700 mt-1">Pengirimannya cepat dan barang sesuai deskripsi.</p>
                    </div>
                </div>
    
                <!-- Tombol Beri Review di kanan bawah -->
                <div class="flex justify-end">
                    <a href=""
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg flex items-center space-x-2 shadow-md hover:bg-gray-300 transition duration-300 ease-in-out">
                        <span class="text-lg font-bold">+</span>
                        <span class="font-semibold">Beri Review</span>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</div>
