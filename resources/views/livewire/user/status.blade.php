<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Pemesanan</h1>
            <a href="/" class="text-orange-600 hover:text-orange-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali Ke Home
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <form wire:submit.prevent="render" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" wire:model.live="search" placeholder="Cari nomor pesanan..."
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200">
                </div>

                <div class="w-full sm:w-auto">
                    <select wire:model.live="statusFilter"
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu Pembayaran</option>
                        <option value="paid">Sudah Dibayar</option>
                        <option value="processing">Diproses</option>
                        <option value="shipped">Dikirim</option>
                        <option value="delivered">Diterima</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>

                <div class="w-full sm:w-auto">
                    <button type="submit"
                        class="w-full px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="space-y-4">
            @if ($orders->count() > 0)
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex flex-wrap justify-between items-start gap-4">
                            <div>
                                <div class="text-lg font-medium">Pesanan #{{$loop->iteration }}</div>
                                <div class="text-sm text-gray-500">{{ $order->created_at }}</div>
                            </div>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                {{ $order->status === 'pending' ? 'bg-yellow-400 text-white' : '' }}
                                {{ $order->status === 'paid' ? 'bg-orange-500 text-white' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-500 text-white' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-purple-500 text-white' : '' }}
                                {{ $order->status === 'delivered' ? 'bg-green-500 text-white' : '' }}
                                {{ $order->status === 'completed' ? 'bg-gray-500 text-white' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-500 text-white' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div class="mt-4">
                            <div class="text-sm text-gray-600">Total Pesanan:</div>
                            <div class="text-lg font-semibold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="button" onclick="openModal('orderModal{{ $order->id }}')"
                                class="px-4 py-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors">
                                Lihat Detail
                            </button>
                        </div>
                    </div>

                    <div id="orderModal{{ $order->id }}"
                        class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                        <div class="relative top-20 mx-auto p-5 w-full max-w-4xl">
                            <div class="relative bg-white rounded-xl shadow-lg">
                                <div class="p-6">
                                    <div class="space-y-4">
                                        <h4 class="font-medium text-lg">Produk yang Dipesan</h4>
                                        <div class="space-y-3">
                                            @php
                                                $orderDetails = $this->getOrderDetail($order->id);
                                            @endphp
                                            @if($orderDetails->count() > 0)
                                                @foreach($orderDetails as $orderDetail)
                                                    <div class="flex justify-between items-center py-3 border-b">
                                                        <div>
                                                            <div class="font-medium">{{ $orderDetail->produk->nama_produk }}</div>
                                                            <div class="text-sm text-gray-500">Harga: Rp {{ number_format($orderDetail->produk->harga, 0, ',', '.') }}</div>
                                                            <div class="text-sm text-gray-500">Jumlah: {{ $orderDetail->quantity }}</div>
                                                        </div>
                                                        <div class="font-medium">Rp {{ number_format($orderDetail->produk->harga * $orderDetail->quantity, 0, ',', '.') }}</div>
                                                    </div>
                                                @endforeach

                                                <div class="mt-4">
                                                    <div class="flex justify-between items-center">
                                                        <div class="text-sm text-gray-600">Ongkir:</div>
                                                        <div class="text-sm text-gray-500">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</div> 
                                                    </div>
                                                    <div class="flex justify-between items-center">
                                                        <div class="text-sm text-gray-600">Biaya Admin:</div>
                                                        <div class="text-sm text-gray-500">Rp {{ number_format(2000, 0, ',', '.') }}</div>
                                                    </div>
                                                </div>

                                                <div class="flex justify-between items-center pt-3 font-medium">
                                                    <div>Total:</div>
                                                    <div>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div> 
                                                </div>
                                            @else
                                                <p class="text-gray-600">Detail pesanan tidak tersedia.</p>
                                            @endif
                                        </div>

                                        <div class="mt-6">
                                            <h4 class="font-medium text-lg">Alamat Pengiriman</h4>
                                            <p class="mt-2 text-gray-600">{{ $order->alamat }}</p>
                                        </div>

                                        <div class="mt-6">
                                            <h4 class="font-medium text-lg">Catatan</h4>
                                            <p class="mt-2 text-gray-600">{{ $order->catatan }}</p>
                                        </div>
                                    </div>

                                    <div class="flex justify-between gap-3 mt-6 p-4 border-t">
                                        <button type="button" onclick="closeModal('orderModal{{ $order->id }}')"
                                            class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors">
                                            Tutup
                                        </button>
                                        @if ($order->status === 'delivered')
                                            <button wire:click="markAsCompleted({{ $order->id }})"
                                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                                Pesanan Sudah Diterima
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <p class="text-gray-600">Pesanan kosong.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        const modals = document.querySelectorAll('.fixed.inset-0');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    }

    window.addEventListener('closeModal', event => {
        closeModal(event.detail.modalId);
    });
</script>