<div>
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-lg font-semibold mb-4">Daftar Order</h2>

        <div class="relative overflow-x-auto mt-5 shadow-md sm:rounded-lg hidden sm:block">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dat-table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Pesanan Dari</th>
                        <th scope="col" class="px-6 py-3">Nomor Resi Pesanan</th>
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
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->resi_code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->nama_penerima }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->metode_pembayaran }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a wire:click="openModal({{ $order->id }})" 
                                class="px-3 py-1 rounded-lg text-white font-semibold text-sm cursor-pointer
                                {{ $order->status === 'pending' ? 'bg-yellow-400' : '' }}
                                {{ $order->status === 'paid' ? 'bg-orange-400' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-500' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-purple-500' : '' }}
                                {{ $order->status === 'delivered' ? 'bg-green-500' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-500' : '' }}
                                {{ $order->status === 'completed' ? 'bg-orange-700' : '' }}">
                                {{ ucfirst($order->status) }}
                            </a>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at }}</td>
                        <td class="px-6 py-4 text-right">
                            <x-secondary-button wire:click="showOrders({{ $order->id }})"
                                class="px-4 py-2 whitespace-nowrap bg-blue-500 text-white rounded hover:bg-blue-600">
                                Lihat Detail
                            </x-secondary-button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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
                        {{ $order->status === 'paid' ? 'bg-orange-400' : '' }}
                        {{ $order->status === 'processing' ? 'bg-blue-500' : '' }}
                        {{ $order->status === 'shipped' ? 'bg-purple-500' : '' }}
                        {{ $order->status === 'delivered' ? 'bg-green-500' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-500' : '' }}
                        {{ $order->status === 'completed' ? 'bg-orange-700' : '' }}">
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

    @if ($selectedOrder)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl overflow-y-auto max-h-[80vh]">
                <h2 class="text-lg font-semibold mb-4">Detail Order</h2>

                <div class="space-y-6">
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4">Informasi Pemesan</h3>
                        <div class="space-y-2">
                            <p class="text-gray-600"><strong>Pesanan Dari:</strong> {{ $selectedOrder->user->name }}</p>
                            <p class="text-gray-600"><strong>Nama Penerima:</strong> {{ $selectedOrder->nama_penerima }}</p>
                        </div>
                    </div>
                
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4">Informasi Pengiriman</h3>
                        <div class="space-y-2">
                            <p class="text-gray-600"><strong>Alamat Pengiriman:</strong> {{ $selectedOrder->alamat }}</p>
                            {{-- <p class="text-gray-600"><strong>Provinsi Tujuan:</strong> {{ $this->getProvinceName($order->id_provinsi) }}</p>
                            <p class="text-gray-600"><strong>Kota Tujuan:</strong> {{ $this->getCityName($order->id_provinsi, $order->id_kota) }}</p> --}}
                            <p class="text-gray-600"><strong>Catatan:</strong> {{ $selectedOrder->catatan }}</p>
                        </div>
                    </div>

                    {{-- data Produk --}}
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4">Produk yang Dipesan</h3>
                          @php
                          $orderDetails = $this->getOrderDetail($order->id);
                          @endphp
                        
                        @if($this->orderDetails && $this->orderDetails->count() > 0)
                        <div class="space-y-3">
                            @foreach($this->orderDetails as $orderDetail)
                                    <div class="flex justify-between items-center py-3 border-b">
                                        <div>
                                            @if ($orderDetail->produk)
                                                <div class="font-medium">{{ $orderDetail->produk->nama_produk }}</div>
                                                <div class="text-sm text-gray-500">Harga: Rp {{ number_format($orderDetail->produk->harga, 0, ',', '.') }}</div>
                                                <div class="text-sm text-gray-500">Jumlah: {{ $orderDetail->quantity }}</div>
                                            @else
                                                <div>
                                                    <div class="font-medium">Produk Tidak Ditemukan</div>
                                                </div>
                                            @endif
                                        </div>
                                        @if ($orderDetail->produk)
                                            <div class="font-medium">Rp {{ number_format($orderDetail->produk->harga * $orderDetail->quantity, 0, ',', '.') }}</div>
                                        @endif
                                    </div>
                                @endforeach
                
                                <div class="mt-4">
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-600">Ongkir:</div>
                                        <div class="text-sm text-gray-500">Rp {{ number_format($selectedOrder->ongkir, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-600">Biaya Admin:</div>
                                        <div class="text-sm text-gray-500">Rp {{ number_format(2000, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                
                                <div class="flex justify-between items-center pt-3 font-medium">
                                    <div>Total:</div>
                                    <div>Rp {{ number_format($selectedOrder->total_harga, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-600">Detail pesanan tidak tersedia.</p>
                        @endif
                    </div>
                
                    {{-- Info Bayar --}}
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4">Informasi Pembayaran</h3>
                        <div class="space-y-2">
                            <p class="text-gray-600"><strong>Status:</strong> {{ ucfirst($selectedOrder->status) }}</p>
                            <p class="text-gray-600"><strong>Metode Pembayaran:</strong> {{ $selectedOrder->midtrans_payment_type }}</p>
                            <p class="text-gray-600"><strong>Snap Token:</strong> {{ $selectedOrder->snap_token }}</p>
                            <p class="text-gray-600"><strong>Kode Resi:</strong> {{ $selectedOrder->resi_code }}</p>
                        </div>
                        <div class="flex justify-between items-center mt-4 p-4 border-t">
                            <p class="text-gray-600"><strong>Total Harga:</strong> Rp {{ number_format($selectedOrder->total_harga, 0, ',', '.') }}</p>
                            <p class="text-gray-600"><strong>Total Berat:</strong> {{ number_format($selectedOrder->total_berat, 0, ',', '.') }} Gram</p>
                        </div>
                    </div>
                
                </div>

                <div class="flex justify-end gap-3 mt-6 p-4 border-t">
                    <button wire:click="closeModal" class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

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