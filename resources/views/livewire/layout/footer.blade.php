<footer class="bg-white border-t border-gray-100 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Store Info -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 flex items-center justify-center">
                        <x-application-logo/>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-900">Cod-ng Store</span>
                </div>
                <p class="text-gray-500">Solusi digital yang tepat untuk Anda, selalu memberikan pelayanan terbaik.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Quick Links</h3>
                <div class="mt-4 space-y-2">
                    <a href="/" class="block text-gray-500 hover:text-softoren">Home</a>
                    <a href="#produk-section" class="block text-gray-500 hover:text-softoren">Products</a>
                    <a href="#about-section" class="block text-gray-500 hover:text-softoren">About Us</a>

                    <a wire:click="logout" class="block text-gray-500 hover:text-softoren cursor-pointer">
                        Logout
                    </a>
                    
                </div>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Contact</h3>
                <div class="mt-4 space-y-2">
                    <p class="text-gray-500">coding@gmail.com</p>
                    <p class="text-gray-500">+62 80987654321</p>
                    <p class="text-gray-500">Banjarmasin, Kalimantan Selatan</p>
                </div>
            </div>

            <!-- Social Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Follow Us</h3>
                <div class="mt-4 flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-softoren">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-softoren">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-softoren">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.163c3.204 0 3.584.012 4.849.07 1.17.054 1.985.24 2.663.51a5.42 5.42 0 0 1 1.884 1.263 5.42 5.42 0 0 1 1.263 1.884c.27.678.456 1.493.51 2.663.058 1.265.07 1.645.07 4.849s-.012 3.584-.07 4.849c-.054 1.17-.24 1.985-.51 2.663a5.42 5.42 0 0 1-1.263 1.884 5.42 5.42 0 0 1-1.884 1.263c-.678.27-1.493.456-2.663.51-1.265.058-1.645.07-4.849.07s-3.584-.012-4.849-.07c-1.17-.054-1.985-.24-2.663-.51a5.42 5.42 0 0 1-1.884-1.263 5.42 5.42 0 0 1-1.263-1.884c-.27-.678-.456-1.493-.51-2.663-.058-1.265-.07-1.645-.07-4.849s.012-3.584.07-4.849c.054-1.17.24-1.985.51-2.663a5.42 5.42 0 0 1 1.263-1.884A5.42 5.42 0 0 1 4.488 2.74c.678-.27 1.493-.456 2.663-.51C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.74 0 8.332.015 7.052.072 5.775.132 4.905.333 4.14.63a7.41 7.41 0 0 0-2.126 1.384A7.41 7.41 0 0 0 .63 4.14C.333 4.905.131 5.775.072 7.053.012 8.332 0 8.74 0 12c0 3.26.015 3.668.072 4.947.06 1.277.261 2.147.558 2.913a7.41 7.41 0 0 0 1.384 2.126A7.41 7.41 0 0 0 4.14 23.37c.765.297 1.636.499 2.913.558C8.332 23.988 8.74 24 12 24s3.668-.015 4.947-.072c1.277-.06 2.148-.261 2.913-.558a7.41 7.41 0 0 0 2.126-1.384 7.41 7.41 0 0 0 1.384-2.126c.297-.765.499-1.636.558-2.913C23.988 15.668 24 15.26 24 12s-.015-3.668-.072-4.947c-.06-1.277-.261-2.148-.558-2.913a7.41 7.41 0 0 0-1.384-2.126A7.41 7.41 0 0 0 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.668.012 15.26 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-10.687a1.44 1.44 0 1 1 0-2.88 1.44 1.44 0 0 1 0 2.88z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-12 border-t border-gray-100 pt-8">
            <p class="text-center text-gray-400">© Cod-ng 2025 Store. All rights reserved.</p>
        </div>
    </div>
</footer>