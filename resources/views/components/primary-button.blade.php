<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#FF8201] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#fc942c] focus:[#fc942c] active:[#fc942c] focus:outline-none focus:ring-4 focus:[#fc942c] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
