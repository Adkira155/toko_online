<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>
<div>
    <aside id="sidebar" class="h-screen w-64 bg-white shadow transition-all duration-300 z-40">
        <div class="flex flex-col h-full">
            <!-- Logo -->
            <div class="px-4 py-4 border-b">
                {{-- <div class="">
                   <center> <x-application-logo/></center>
                </div> --}}
                <div class="text-center">
                    <h2 class="text-sky-700 font-bold text-lg">Admin</h2>
                    <small class="text-gray-500">Panel Manajemen</small>
                </div>
                
            </div>

            <!-- Navigation -->
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
                    <div class="mt-4">
                        <p class="px-3 text-xs font-semibold uppercase text-gray-500">Manajemen Pengguna</p>
                        <a href="{{ route('user.tabel') }}" class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('user.tabel') ? 'bg-gray-200 text-gray-900 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                            <span>Pengguna</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- User Profile -->
            
            <div class="border-t p-3 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-teal-200 flex items-center justify-center">
                    <img src="{{ asset('storage/akira.png') }}" alt="Akira" class="w-full h-full rounded-full">
                </div>
                <div class="flex-grow">
                    <h6 class="text-gray-900 font-medium">{{ Auth::user()->name }}</h6>
                    <small class="text-gray-500">{{ Auth::user()->role }}</small>
                </div>
                <div class="relative">
                    <button id="dropdownToggle" class="text-gray-600 focus:outline-none">
                        ...
                    </button>
                    <ul id="dropdownMenu" class="absolute right-0 bottom-full mb-2 w-40 bg-white shadow-lg rounded-md overflow-hidden hidden">
                        {{-- <x-dropdown-link href="{{ route('profile') }}">Profile</x-dropdown-link> --}}
                        <x-dropdown-link wire:click="logout" class="cursor-pointer">Logout</x-dropdown-link>
                        
                    </ul>
                </div>
            </div>
            
        </div>
    </aside>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dropdownToggle = document.getElementById("dropdownToggle");
            const dropdownMenu = document.getElementById("dropdownMenu");
            
            dropdownToggle.addEventListener("click", function (event) {
                event.stopPropagation();
                dropdownMenu.classList.toggle("hidden");
            });

            document.addEventListener("click", function (event) {
                if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add("hidden");
                }
            });
        });
    </script>
</div>
