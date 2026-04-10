@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 focus:border-canteen-400 focus:ring-canteen-400 rounded-xl shadow-sm']) }}>
