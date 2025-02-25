@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#fc942c] focus:ring-[#fc942c] rounded-md shadow-sm']) }}>
