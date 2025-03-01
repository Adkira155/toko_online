<div class="flex items-center gap-3">
               
        <div x-data="{ open: false }" class="relative z-50">
            <button @click="open = !open" class="text-gray-600 text-2xl px-4 py-2 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12h.01M12 12h.01M18 12h.01" />
                </svg>
            </button>
            <ul x-show="open" @click.away="open = false" class="absolute right-0 top-full mt-2 w-40 bg-white shadow-md rounded-md overflow-hidden z-50">
                <x-dropdown-link wire:click="logout" class="cursor-pointer">Logout</x-dropdown-link>
            </ul>
        </div>
        <div class="flex-grow text-right mr-4">
            <h6 class="text-gray-900 font-medium">{{ Auth::user()->name }}</h6>
            <small class="text-gray-500">{{ Auth::user()->role }}</small>
        </div>
        <div class="w-10 h-10 rounded-full bg-teal-200 flex items-center justify-center">
            <img src="{{ asset('img/akira.png') }}" alt="Akira" class="w-full h-full rounded-full">
        </div>

        

    </div>

