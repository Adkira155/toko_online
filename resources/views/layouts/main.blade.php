<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    {{-- @yield('title', 'Admin Dashboard')  --}}
    @vite('resources/css/app.css')
    @stack('styles')
    @livewireStyles
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('img/Coding.png') }}">


    <style>
        body {
            min-height: 100vh;
            background: #f5f6fa;
        }

        .layout-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        .content-wrapper {
            flex: 1;
            min-width: 0;
            transition: margin-left 0.3s ease;
        }

        @media (min-width: 992px) {
            .content-wrapper {
                margin-left: 16rem;
            }

            .content-wrapper.sidebar-collapsed {
                margin-left: 4.5rem;
            }
        }

        @media (max-width: 991.98px) {
            .content-wrapper {
                margin-left: 0;
            }
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body>
    <div class="layout-container">
        <livewire:layout.sidebar />
            <div class="content-wrapper d-flex flex-column min-vh-100" id="contentWrapper">
                <x-admin-header />
            
                <main class="p-4 flex-grow-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                        <!-- Total Penjualan Card -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-emerald-50 rounded-lg">
                                        <svg class="w-6 h-6 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-gray-600 font-medium">Penjualan</h3>
                                </div>
                            </div>
                            <div class="flex items-baseline">
                                <p class="text-3xl font-bold text-gray-900">Rp 0</p>
                                <span class="ml-2 text-sm text-gray-500">this month</span>
                            </div>
                        </div>
                
                        <!-- Total Pesanan Card -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-blue-50 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-gray-600 font-medium">Pesanan</h3>
                                </div>
                            </div>
                            <div class="flex items-baseline">
                                <p class="text-3xl font-bold text-gray-900">0</p>
                                <span class="ml-2 text-sm text-gray-500">pesanan</span>
                            </div>
                            <div class="mt-4 grid grid-cols-3 gap-4">
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-500">Pending</p>
                                    <p class="font-semibold text-gray-900">0</p>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-500">Proses</p>
                                    <p class="font-semibold text-gray-900">0</p>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-500">Selesai</p>
                                    <p class="font-semibold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>
                
                        <!-- Produk Card -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-teal-50 rounded-lg">
                                        <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-gray-600 font-medium">Produk</h3>
                                </div>
                            </div>
                            <div class="flex items-baseline">
                                <p class="text-3xl font-bold text-gray-900">0</p>
                                <span class="ml-2 text-sm text-gray-500">total produk</span>
                            </div>
                            <div class="mt-4 grid grid-cols-2 gap-4">
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-500">Stok</p>
                                    <p class="font-semibold text-gray-900">0</p>
                                </div>
                            </div>
                        </div>
                
                        <!-- Pelanggan Card -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-lime-50 rounded-lg">
                                        <svg class="w-6 h-6 text-lime-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-gray-600 font-medium">Pelanggan</h3>
                                </div>
                            </div>
                            <div class="flex items-baseline">
                                <p class="text-3xl font-bold text-gray-900">0</p>
                                <span class="ml-2 text-sm text-gray-500">telah daftar</span>
                            </div>
                        </div>
                    </div>
                
                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
                        <!-- Sales Chart -->
                       
                        <!-- Top Products -->
                        
                    </div>
                </main>
                
            
                <footer class="bg-light py-3 text-center">
                    <p class="mb-0">© 2025 Nama Perusahaan. All rights reserved.</p>
                </footer>
            </div>
            

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

    @stack('scripts')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @livewireScripts
</body>

</html>