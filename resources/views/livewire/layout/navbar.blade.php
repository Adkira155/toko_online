<div>
    <nav class="bg-white border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <!-- Logo -->
            <a href="https://waqtuns.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://www.waqtuns.com/waqtuns.png" class="h-8" alt="Waqtuns Logo" />
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
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white">
                    
                    @auth
                    <!-- Admin Menu -->
                        @if (Auth::user()->role === 'admin')
                        <li>
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
                            <x-dropdown-link href="{{ route('produk.create') }}">Tambah Produk</x-dropdown-link>
                            <x-dropdown-link href="{{ route('produk.create') }}">Daftar Produk</x-dropdown-link>
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
                        </x-dropdown>
                        @endif

                        <!-- User Menu -->
                        @if (Auth::user()->role === 'user')
                        <li>
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                        </li>
                        <li>
                            <x-nav-link href="{{ route('produk.data') }}" :active="request()->routeIs('produk.data')">Produk</x-nav-link>
                        </li>
                        <li>
                            <x-nav-link href="{{ route('user.keranjang') }}" :active="request()->routeIs('user.keranjang')">Keranjang</x-nav-link>
                        </li>
                        @endif
                    @endauth

                    <!-- Guest Menu -->
                    @guest
                    <li>
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('produk.data') }}" :active="request()->routeIs('produk.data')">Produk</x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('user.keranjang') }}" :active="request()->routeIs('user.keranjang')">Keranjang</x-nav-link>
                    </li>
                    @endguest

                    <!-- Authentication Links -->
                    @if (!Auth::check())
                    <li>
                        <a href="{{ route('login') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Register</a>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('profile') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Profile</a>
                    </li>
                    <li>
                        <x-nav-link wire:click="logout" class="cursor-pointer">Logout</x-nav-link>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>
