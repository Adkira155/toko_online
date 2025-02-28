<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Untuk semua pengguna yang login --}}
    @auth
        {{-- Jika role adalah admin --}}
        @if (Auth::user()->role === 'admin')
        <livewire:admin.dashboard-admin />
            {{-- <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 flex items-center space-x-4">
                            
                            <!-- Foto Pengguna -->
                            <img src="{{ asset('images/user.png') }}" alt="Foto Pengguna" class="w-20 h-20 rounded-full object-cover">
                            
                            <!-- Data Pengguna -->
                            <div>
                                <h4 class="text-lg font-semibold">Selamat Datang, {{ Auth::user()->name }} !!</h4>
                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                <a href="{{ route('admin.dashboard') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Buka panel admin</a>
                            </div>
                        </div>
                    </div
                </div>
            </div> --}}

 

        @elseif (Auth::user()->role === 'user')
        <livewire:layout.hero />
        <livewire:layout.card-info />
        {{-- <livewire:layout.shop-category />
        <livewire:layout.produk-random /> --}}
        @endif
    @endauth

    {{-- Jika pengguna adalah guest (tidak login) --}}
    @guest
    <livewire:layout.hero />
    <livewire:layout.card-info />
    <livewire:layout.about />
    {{-- <livewire:layout.shop-category />
    <livewire:layout.produk-random /> --}}
    @endguest

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll('.scroll-link');
        
            links.forEach(link => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
        
                    const targetId = this.getAttribute("href").substring(1);
                    const targetSection = document.getElementById(targetId);
        
                    if (targetSection) {
                        const yOffset = -70; // Sesuaikan agar tidak tertutup navbar
                        const y = targetSection.getBoundingClientRect().top + window.pageYOffset + yOffset;
        
                        window.scrollTo({ top: y, behavior: "smooth" });
                    }
                });
            });
        });
        </script>
        
</x-app-layout>
