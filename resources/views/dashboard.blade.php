<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Untuk semua pengguna yang login --}}
    @auth
        {{-- Jika role adalah admin --}}
        @if (Auth::user()->role === 'admin')
            <h1>admin</h1>
        @elseif (Auth::user()->role === 'user')
        <livewire:layout.hero />
        <livewire:layout.card-info />
        <livewire:layout.shop-category />
        <livewire:layout.produk-random />
        @endif
    @endauth

    {{-- Jika pengguna adalah guest (tidak login) --}}
    @guest
    <livewire:layout.hero />
    <livewire:layout.card-info />
    <livewire:layout.shop-category />
    <livewire:layout.produk-random />
    @endguest
</x-app-layout>
