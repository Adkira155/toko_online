<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#C62B00] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#d83030] active:bg-[#d83030] focus:outline-none focus:ring-2 focus:ring-[#d83030] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
