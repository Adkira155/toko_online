<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-softoren border border-transparent rounded-md uppercase text-xs text-white hover:bg-hvoren focus:[#fc942c] active:[#fc942c] focus:outline-none focus:ring-4 focus:[#fc942c] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
