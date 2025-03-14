@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block py-2 px-3 text-white bg-softoren rounded md:bg-transparent md:text-softoren md:p-0'
            : 'block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-softoren md:p-0';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
