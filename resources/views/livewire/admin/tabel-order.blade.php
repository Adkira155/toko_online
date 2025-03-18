<div>
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-lg font-semibold mb-4">Daftar Order</h2>

        <div class="relative overflow-x-auto mt-5 shadow-md sm:rounded-lg hidden sm:block">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dat-table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Pesanan Dari</th>
                        <th scope="col" class="px-6 py-3">Produk yang dipesan</th>
                        <th scope="col" class="px-6 py-3">Total Harga</th>
                        <th scope="col" class="px-6 py-3">Nama Penerima</th>
                        <th scope="col" class="px-6 py-3">Metode Pembayaran</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Tanggal Order</th>
                        <th scope="col" class="px-6 py-3 whitespace-nowrap min-w-[150px]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->orderdetail->produk->nama_produk }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->nama_penerima }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->metode_pembayaran }}</td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a wire:click="openModal({{ $order->id }})" 
                                   class="px-3 py-1 rounded-lg text-white font-semibold text-sm cursor-pointer
                                   {{ $order->status === 'pending' ? 'bg-yellow-400' : '' }}
                                   {{ $order->status === 'processing' ? 'bg-blue-500' : '' }}
                                   {{ $order->status === 'shipped' ? 'bg-purple-500' : '' }}
                                   {{ $order->status === 'delivered' ? 'bg-green-500' : '' }}
                                   {{ $order->status === 'cancelled' ? 'bg-red-500' : '' }}
                                   {{ $order->status === 'completed' ? 'bg-orange-500' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </a>
                 </td>
                            
                            
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at }}</td>
                            <td class="px-6 py-4 text-right">

                                {{-- detail --}}
                                <x-secondary-button wire:click="showOrders({{ $order->id }})"
                                    class="px-4 py-2 whitespace-nowrap bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Lihat Detail
                                </x-secondary-button>

                                {{-- hapus
                                    <x-danger-button wire:click="hapusOrder({{ $order->id }})" class="ml-2 px-4 py-2">Hapus</x-danger-button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tampilan kartu untuk mobile -->
    <div class="block sm:hidden">
        @foreach($orders as $order)
            <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                <p class="mt-2 text-sm font-semibold">Pesanan Dari: {{ $order->user->name }}</p>
                <p class="mt-2 text-sm text-gray-600">Produk: {{ $order->orderdetail->produk->nama_produk }}</p>
                <p class="mt-2 text-sm text-gray-600">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                <p class="mt-2 text-sm text-gray-600">Nama Penerima: {{ $order->nama_penerima }}</p>
                <p class="mt-2 text-sm text-gray-600">Metode: {{ $order->metode_pembayaran }}</p>
                <p class="mt-2 text-sm text-gray-600">Status:
                    <span class="px-3 py-1 rounded-lg text-white text-sm font-semibold
                        {{ $order->status === 'pending' ? 'bg-yellow-400' : '' }}
                        {{ $order->status === 'processing' ? 'bg-blue-500' : '' }}
                        {{ $order->status === 'shipped' ? 'bg-purple-500' : '' }}
                        {{ $order->status === 'delivered' ? 'bg-green-500' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-500' : '' }}
                        {{ $order->status === 'completed' ? 'bg-orange-500' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p class="mt-2 text-sm text-gray-600">Tanggal: {{ $order->created_at }}</p>

                <div class="mt-2 flex justify-between space-x-2">
                    <x-primary-button wire:click="openModal({{ $order->id }})">
                        Status
                    </x-primary-button>
                    <x-secondary-button wire:click="showOrders({{ $order->id }})"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Lihat Detail
                    </x-secondary-button>
                </div>
            </div>
        @endforeach
    </div>

        <div class="mt-4">{{ $orders->links() }}</div>
    </div>

       <!-- Main modal -->
    @if ($selectedOrder)
       <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
           <div class="bg-white p-6 rounded-lg shadow-lg w-96 overflow-y-auto max-h-[80vh]">
               <h2 class="text-lg font-semibold mb-4">Detail Order</h2>
   
               <p class="text-gray-600"><strong>Pesanan Dari:</strong> {{ $selectedOrder->user->name }}</p>
               <p class="text-gray-600"><strong>Nama Penerima:</strong> {{ $selectedOrder->nama_penerima }}</p>
               <p class="text-gray-600"><strong>Total Harga:</strong> Rp {{ number_format($selectedOrder->total_price, 0, ',', '.') }}</p>
               <p class="text-gray-600"><strong>Status:</strong> {{ ucfirst($selectedOrder->status) }}</p>
               <p class="text-gray-600"><strong>Metode Pembayaran:</strong> {{ $selectedOrder->metode_pembayaran }}</p>
               <p class="text-gray-600"><strong>Ongkos Kirim:</strong> Rp {{ number_format($selectedOrder->ongkir, 0, ',', '.') }}</p>
               <p class="text-gray-600"><strong>Alamat Pengiriman:</strong> {{ $selectedOrder->shipping_address }}</p>
               <p class="text-gray-600"><strong>Catatan:</strong> {{ $selectedOrder->catatan }}</p>
   
               <h3 class="text-lg font-semibold mt-4">Produk yang Dipesan</h3>
   
               @if ($selectedOrder->produk)
                   <ul class="mt-2">
                       <li class="border-b border-gray-200 py-2">
                           <img class="w-full h-auto object-cover rounded" 
                                src="{{ asset('storage/' . $selectedOrder->produk->image) }}" 
                                alt="{{ $selectedOrder->produk->nama_produk }}">
   
                           <p class="text-gray-600"><strong>Nama Produk:</strong> {{ $selectedOrder->produk->nama_produk }}</p>
                           <p class="text-gray-600"><strong>Harga:</strong> Rp {{ number_format($selectedOrder->produk->harga, 0, ',', '.') }}</p>
                        </li>
                   </ul>
               @else
                   <p class="text-red-600">Produk tidak ditemukan untuk order ini.</p>
               @endif
   
               <button wire:click="closeModal" class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                   Tutup
               </button>
           </div>
       </div>
    @endif

    <!-- Modal Update Status -->
    @if ($showModal)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Update Status Pesanan</h2>

            <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Pilih Status</label>
            <select wire:model="status" id="status" class="w-full border-gray-300 rounded-lg p-2">
                @foreach($statuses as $s)
                    <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                @endforeach
            </select>

            <div class="mt-4 flex justify-end space-x-2">
                <button wire:click="closeModal" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                <button wire:click="updateStatus" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
            </div>
        </div>
    </div>
    @endif

       


    @script
    <script>
        $(document).ready(function() {
            var table = $('.dat-table').DataTable({
                responsive: true
            }).columns.adjust().responsive.recalc();
        });
    </script>
    @endscript
</div>