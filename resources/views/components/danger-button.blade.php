<button {{ $attributes->merge(['type' => 'submit', 'class' => 'relative inline-flex items-center px-4 py-2 bg-[#C62B00] border border-transparent rounded-md uppercase text-xs text-white shadow-lg hover:shadow-[#d83030] hover:shadow-md transition-all duration-300 ease-in-out']) }}>
    {{ $slot }}
</button>