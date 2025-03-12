<div class="flex min-h-screen">
    <!-- Tombol Toggle Sidebar -->
    <input type="checkbox" id="sidebar-toggle" class="hidden peer">

    <label for="sidebar-toggle" 
        class="fixed top-4 left-4 z-50 p-2 text-gray-600 bg-white rounded-md shadow-md cursor-pointer">
        ☰
    </label>

    <!-- Sidebar -->
    <aside
        class="absolute md:fixed inset-y-0 left-0 w-64 md:w-60 h-full bg-white shadow-md 
               transform -translate-x-full peer-checked:translate-x-0 
               md:translate-x-0 md:peer-checked:-translate-x-full
               transition-transform duration-300 ease-in-out z-40 overflow-y-auto">
        <div class="flex flex-col h-full">
            <div class="px-3 py-3 border-b text-center">
                <h2 class="text-sky-700 font-bold text-lg">Admin</h2>
                <small class="text-gray-500">Panel Manajemen</small>
            </div>

            <nav class="flex-grow px-3 py-4">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors 
                       {{ request()->routeIs('dashboard') ? 'bg-gray-200 text-gray-900 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>

                    <div class="mt-4">
                        <p class="px-3 text-xs font-semibold uppercase text-gray-500">Manajemen Katalog</p>
                        <a href="{{ route('tabel.produk') }}" 
                           class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors 
                           {{ request()->routeIs('tabel.produk') ? 'bg-gray-200 text-gray-900 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                            <span>Produk</span>
                        </a>
                    </div>

                    <div class="mt-4">
                        <p class="px-3 text-xs font-semibold uppercase text-gray-500">Manajemen Pesanan</p>
                        <a href="{{ route('tabel.order') }}" 
                           class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors 
                           {{ request()->routeIs('tabel.order') ? 'bg-gray-200 text-gray-900 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                            <span>Pesanan</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Konten Utama -->
    <div class="flex-1 p-4 md:p-6 transition-all duration-300 peer-checked:ml-0 md:ml-64 md:peer-checked:ml-0">
        @yield('content')
    </div>
</div>
