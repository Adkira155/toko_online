<button {{ $attributes->merge(['type' => 'submit', 'class' => 'relative inline-flex items-center px-4 py-2 bg-softoren border border-transparent rounded-md uppercase text-xs text-white shadow-lg hover:shadow-[#fc942c] hover:shadow-md transition-all duration-300 ease-in-out']) }}>
    {{ $slot }}
</button>
