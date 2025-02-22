<x-app-layout>
    <div class="container mx-auto">
        @livewire('admin.user.update-user', ['id' => $id])
    </div>
</x-app-layout>
{{-- <x-app-layout>
    <livewire:admin.user.update-user :id="$id" />
</x-app-layout> --}}
