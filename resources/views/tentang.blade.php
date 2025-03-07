<x-app-layout>
   
    


    <div id="about-section" class="py-12">
        <div class="container mx-auto px-6 sm:px-8">
            <div class="max-w-4xl mx-auto bg-white rounded-lg p-6 sm:p-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-center text-gray-900 mb-4 sm:mb-6">Tentang Kami</h1>
                <p class="text-gray-700 text-base sm:text-lg leading-relaxed text-center">
                    Selamat datang di <span class="font-semibold text-orange-500">{{ config('app.name') }}</span>! 
                    Kami adalah tim yang berdedikasi untuk memberikan layanan terbaik kepada Anda. Dengan pengalaman luas 
                    dan komitmen tinggi, kami terus berkembang untuk menghadirkan solusi inovatif yang bermanfaat.
                </p>

                <div class="flex justify-center">
                    <img src="{{asset('img/coding.png')}}" alt="logo" class="w-48 h-auto">
                </div>
    
                <div class="mt-6 sm:mt-8">
                    <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 mb-3 sm:mb-4">Visi & Misi</h2>
                    <ul class="list-none text-gray-700 space-y-2 text-center text-sm sm:text-base">
                        <li>✅ Memberikan layanan berkualitas tinggi untuk kepuasan pelanggan.</li>
                        <li>✅ Mengembangkan teknologi yang inovatif dan berkelanjutan.</li>
                        <li>✅ Menciptakan lingkungan kerja yang profesional dan kolaboratif.</li>
                    </ul>
                </div>
    
                <div class="mt-6 sm:mt-8">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 sm:mb-4 text-center">Tim Kami</h2>
                    <p class="text-gray-700 text-center text-sm sm:text-base">
                        Kami terdiri dari para profesional yang berpengalaman di bidangnya masing-masing, bekerja sama untuk memberikan 
                        layanan terbaik bagi pelanggan kami.
                    </p>
                </div>
            </div>
        </div>
    </div>
    

</x-app-layout>