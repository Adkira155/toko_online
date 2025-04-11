<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg **flex flex-col justify-start**">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>
    
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg **flex flex-col justify-start**">
                <div class="max-w-xl">
                    <livewire:profile.detail-profile-information-form />
                    {{-- <livewire:profile.delete-user-form /> --}}
                </div>
            </div>
    
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg md:col-span-2">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
