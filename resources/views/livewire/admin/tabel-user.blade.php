<div class="bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-lg font-semibold mb-4">Daftar Pengguna</h2>

    <!-- tambah data -->
    <x-primary-button>
    <a href="{{ route('user.create') }}">Tambah Pengguna</a>
    </x-primary-button>

    <!-- Tabel Produk -->


<div class="relative overflow-x-auto mt-5 shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Username
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Gambar
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($user as $pengguna)
            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $loop->iteration }}
                </th>
                <td class="px-6 py-4">
                    {{ $pengguna->name }}
                </td>
                <td class="px-6 py-4">
                    {{ $pengguna->email }}
                </td>
                <td class="px-6 py-4">
                    {{-- {{ asset('storage/' . $pengguna->image) }} --}}
                </td>
                <td class="px-6 py-4 text-right">
                    <x-primary-button>
                        <a href="">Edit</a>
                    </x-primary-button>
                    <x-danger-button>
                        <a wire:click="">Hapus</a>
                    </x-danger-button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>




    <!-- Pagination -->
    
</div>

