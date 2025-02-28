<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    
    </head>
    <body class="">
        <div class="min-h-screen font-[Poppins] bg-white">
            <div class="min-h-screen">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <!-- Sidebar untuk Admin -->
                        <div class="flex">
                            <livewire:layout.sidebar />
                            <div class="flex-1">
                                <div class="flex-1 flex flex-col">
                                    <!-- Header Konten -->
                                    <header class="bg-white shadow-md p-7 flex items-center justify-between md:pl-8">
                                        <!-- Tombol Burger di Mobile -->
                                        
                                        <h1 class="text-xl font-bold ml-14">Dashboard</h1>
                            
                                    </header>
                                </div>
                                <!-- Konten Halaman -->
                                <main class="p-6">
                                    {{ $slot }}
                                </main>
                            </div>
                        </div>
                    @else
                        <!-- Navbar untuk User -->
                        <livewire:layout.navbar />
                        {{-- <header class="p-4 bg-gray-100 shadow">
                            {{ $header ?? '' }}
                        </header> --}}
                        <main class="p-6">
                            {{ $slot }}
                        </main>
                        <livewire:layout.footer />
                    @endif
                @else
                    <!-- Guest -->
                    <livewire:layout.navbar />
                    {{-- <header class="p-4 bg-gray-100 shadow">
                        {{ $header ?? '' }}
                    </header> --}}
                    <main class="p-6">
                        {{ $slot }}
                    </main>
                    <livewire:layout.footer />
                @endauth
            </div>
            
            {{-- Jika pengguna adalah guest (tidak login) --}}
        </div>

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const links = document.querySelectorAll('.scroll-link');
            
                links.forEach(link => {
                    link.addEventListener("click", function(e) {
                        e.preventDefault(); // Mencegah reload halaman
            
                        const targetId = this.getAttribute("href").substring(1);
                        const targetSection = document.getElementById(targetId);
            
                        if (targetSection) {
                            smoothScroll(targetSection);
                        }
                    });
                });
            
                function smoothScroll(target) {
                    const startPosition = window.pageYOffset;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
                    const distance = targetPosition - startPosition;
                    const duration = 800; // Durasi dalam milidetik
                    let startTime = null;
            
                    function animation(currentTime) {
                        if (startTime === null) startTime = currentTime;
                        const timeElapsed = currentTime - startTime;
                        const run = ease(timeElapsed, startPosition, distance, duration);
                        window.scrollTo(0, run);
                        if (timeElapsed < duration) requestAnimationFrame(animation);
                    }
            
                    function ease(t, b, c, d) {
                        t /= d / 2;
                        if (t < 1) return (c / 2) * t * t + b;
                        t--;
                        return (-c / 2) * (t * (t - 2) - 1) + b;
                    }
            
                    requestAnimationFrame(animation);
                }
            });
            </script>
            
        {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script> --}}
    </body>
</html>


