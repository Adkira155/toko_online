<div class="flex-1">
    <div class="flex-1 flex flex-col">
        <!-- Header Konten -->
        <header class="bg-white shadow-md p-3 flex items-center justify-between md:pl-8">
            <!-- Tombol Burger di Mobile -->
            
            <h1 class="text-xl font-bold ml-14">Dashboard</h1>

            <!-- name n logout -->
            <x-dropdown>
                <x-slot:trigger>
                    <button class="block py-2 px-3 w-28 h-8 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">
                        <span class="hidden lg:inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" viewBox="0 0 256 256">
                                <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                                </path>
                            </svg>
                        </span>
                        <span class="text-base font-medium">{{ Auth::user()->name }}</span>
                    </button>
                </x-slot:trigger>
                {{-- berikan kondisi hanya user yang punya profile  --}}
                <x-dropdown-link href="{{ route('profile') }}">Profile</x-dropdown-link>
                <x-dropdown-link wire:click="logout" class="cursor-pointer">Logout</x-dropdown-link>
            </x-dropdown>

            
            

        </header>
    </div>
    <!-- Konten Halaman -->
    <main class="p-6">
        {{ $slot }}
    </main>
</div>