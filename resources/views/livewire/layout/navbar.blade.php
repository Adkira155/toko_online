<div>
    <nav class="bg-white border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-around mx-auto p-4">
                <!-- Logo -->
                <a href="/">
                    <x-application-logo/>
                    </a>
 
            <!-- Mobile Menu Button -->
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            <!-- Navbar Menu -->
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white">                     
                    @auth
                    <!-- Admin Menu -->
                        
                        {{-- <li>
                            <a href="{{ route('dashboard') }}"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Dashboard</a>
                        </li>
                        <x-dropdown>
                            <x-slot:trigger>
                                <button class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">
                                    <span class="hidden lg:inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" viewBox="0 0 256 256">
                                            <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="text-base font-medium">Produk</span>
                                </button>
                            </x-slot:trigger>
                            <x-dropdown-link href="{{ route('tabel.produk') }}">Data Produk</x-dropdown-link>
                            <x-dropdown-link href="{{ route('produk.create') }}">Daftar Produk</x-dropdown-link>
                            <x-nav-link href="{{ route('produk.data') }}" :active="request()->routeIs('produk.data')">Produk</x-nav-link>
                        </x-dropdown>

                        <x-dropdown>
                            <x-slot:trigger>
                                <button class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">
                                    <span class="hidden lg:inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" viewBox="0 0 256 256">
                                            <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="text-base font-medium">Pesanan</span>
                                </button>
                            </x-slot:trigger>
                            <x-dropdown-link href="{{ route('produk.create') }}">Pesanan Baru</x-dropdown-link>
                            <x-dropdown-link href="{{ route('produk.create') }}">Pesanan Dikirim</x-dropdown-link>
                            <x-dropdown-link href="{{ route('produk.create') }}">Riwayat Pesanan</x-dropdown-link>
                        </x-dropdown>

                        <x-dropdown>
                            <x-slot:trigger>
                                <button class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">
                                    <span class="hidden lg:inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" viewBox="0 0 256 256">
                                            <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="text-base font-medium">Kategori</span>
                                </button>
                            </x-slot:trigger>
                            <x-dropdown-link href="{{ route('produk.create') }}">Tambah Kategori</x-dropdown-link>
                            @foreach ($kategori as $k)
                            <x-dropdown-link href="{{ route('produk.create') }}">{{ $k->nama }}</x-dropdown-link>
                            @endforeach
                        </x-dropdown> --}}

                        <!-- User Menu -->
                        @if (Auth::user()->role === 'user')
                        <li>
                            <a href="/" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-hvoren md:p-0">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('produk.page') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-hvoren md:p-0 cursor-pointer">
                                Produk
                            </a>
                        </li>
                        
                        <li>
                            <a wire:navigate href="{{route('tentang')}}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-hvoren md:p-0">
                                Tentang
                            </a>
                        </li>
                        <li>
                            <x-nav-link href="{{ route('user.keranjang') }}" :active="request()->routeIs('user.keranjang')" class="lg:ml-32">
                                <x-cart-logo/>
                            </x-nav-link>
                        </li>
                        @endif
                    @endauth

                    <!-- Guest Menu -->
                    @guest
                    <ul class="md:flex md:justify-center md:w-full lg:space-x-6">
                        <li>
                            <a href="/" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-hvoren md:p-0">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('produk.page') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-hvoren md:p-0 cursor-pointer">
                                Produk
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{route('tentang')}}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-hvoren md:p-0">
                                Tentang
                            </a>
                        </li>
                    </ul>
                    
                    <li class="flex justify-start">
                        <x-nav-link href="{{ route('user.keranjang') }}" :active="request()->routeIs('user.keranjang')" class="lg:ml-32">
                            <x-cart-logo/>
                        </x-nav-link>
                    </li>
                    
                    @endguest

                    <!-- Authentication Links -->
                    @if (!Auth::check())
    <li class="flex space-x-2 justify-end">
        <x-primary-button onclick="window.location='{{ route('login') }}'">
            Login
        </x-primary-button>
        <x-primary-button onclick="window.location='{{ route('register') }}'">
            Register
        </x-primary-button>
    </li>
@else
    <x-dropdown>
        <x-slot:trigger>
            <button class="block py-2 px-3 w-28 h-8 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-softoren md:p-0">
                <span class="hidden lg:inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" viewBox="0 0 256 256">
                        <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                    </svg>
                </span>
                <span class="text-base font-medium">{{ Auth::user()->name }}</span>
            </button>
        </x-slot:trigger>

        {{-- Cek apakah user adalah admin --}}
        @if (Auth::user()->role === 'user')
            <x-dropdown-link href="{{ route('profile') }}">Profile</x-dropdown-link>
        @endif

        <x-dropdown-link wire:click="logout" class="cursor-pointer">Logout</x-dropdown-link>
    </x-dropdown>
@endif

                </ul>
            </div>
        </div>
    </nav>

    <script>
        Livewire.on('forceRefresh', () => {
            location.reload();
        });
    </script>
    
</div>
