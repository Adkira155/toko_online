<div>
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-lg font-semibold mb-4">Daftar Order</h2>

        <div class="relative overflow-x-auto mt-5 shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dat-table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Pesanan Dari
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Produk yang dipesan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Harga
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Penerima
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Metode Pembayaran
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tanggal Order
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                         </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->id_user }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->id_detailorder }}
                        </td>
                        <td class="px-6 py-4">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ ucfirst($order->status) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->nama_penerima }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->metode_pembayaran }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->created_at }}
                        </td>
                        
                        {{-- aksi --}}
                        <td class="px-6 py-4 text-right">
                            <!-- Detail -->
                            <x-secondary-button
                                class="px-4 py-2">
                                Lihat Detail
                            </x-secondary-button>

                            <x-danger-button wire:click="hapusOrder({{ $order->id }})" class="ml-2 px-4 py-2">
                                Hapus
                            </x-danger-button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>

    @script
    <script>
        $(document).ready(function() {
            var table = $('.dat-table').DataTable({
                responsive: true
            })
            .columns.adjust()
            .responsive.recalc();
        });
    </script>
    @endscript
</div>