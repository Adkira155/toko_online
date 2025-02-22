<div class="bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-lg font-semibold mb-4">Daftar User</h2>

    <!-- tambah data -->
    <a href="{{ route('user.create') }}" class="bg-blue-500 text-white px-2 py-1 rounded">Create</a>

    <!-- Tabel Produk -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">No</th>
                    <th class="border p-2">Nama user</th>
                    <th class="border p-2">email</th>
                    <th class="border p-2">Nomor Telpon</th>
                    <th class="border p-2">status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user as $item)
                <tr class="text-center">
                    <td class="border p-2">{{ $loop->iteration }}</td>
                    <td class="border p-2">{{ $item->name }}</td>
                    <td class="border p-2">{{ $item->email }}</td>
                    <td class="border p-2">{{ $item->nomor }}</td>
                    <td class="border p-2">{{ $item->role }}</td>
                    
                    <td class="border p-2">
                        <a href="{{ route('user.update', $item->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</a>
                        <button wire:click="hapusUser({{ $item->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $user->links() }}
    </div>
</div>
