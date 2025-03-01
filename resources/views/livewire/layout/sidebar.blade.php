<div class="flex flex-col min-h-screen">
    <!-- Tombol Toggle Sidebar -->
    <input type="checkbox" id="sidebar-toggle" class="hidden peer">
    <label for="sidebar-toggle" class="fixed top-4 left-4 z-50 p-2 text-gray-600 bg-white rounded-md shadow-md cursor-pointer md:absolute md:top-4 md:left-4 md:p-2 md:z-10">
        ☰
    </label>

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 h-auto min-h-full bg-white shadow-md transform -translate-x-full peer-checked:translate-x-0 transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:hidden peer-checked:md:block">
        <div class="flex flex-col h-full">
            <!-- Header Sidebar -->
            <div class="px-3 py-3 border-b text-center">
                <h2 class="text-sky-700 font-bold text-lg">Admin</h2>
                <small class="text-gray-500">Panel Manajemen</small>
            </div>

            <!-- Navigasi -->
            <nav class="flex-grow px-3 py-4 overflow-auto">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-200 text-gray-900 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>

                    <div class="mt-4">
                        <p class="px-3 text-xs font-semibold uppercase text-gray-500">Manajemen Katalog</p>
                        <a href="{{ route('tabel.produk') }}" class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('tabel.produk') ? 'bg-gray-200 text-gray-900 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                            <span>Produk</span>
                        </a>
                    </div>
                    <div class="mt-4">
                        <p class="px-3 text-xs font-semibold uppercase text-gray-500">Manajemen Pesanan</p>
                        <a href="" class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('') ? 'bg-gray-200 text-gray-900 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                            <span>Pesanan</span>
                        </a>
                        <a href="" class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('') ? 'bg-gray-200 text-gray-900 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                            <span>Riwayat Pesanan</span>
                        </a>
                    </div>
                   
                </div>
            </nav>

            
        </div>
    </aside>

    <!-- Overlay hanya muncul di mobile -->
    <label for="sidebar-toggle" class="fixed inset-0 hidden peer-checked:block md:peer-checked:hidden"></label>

    
   
</div>
