@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold leading-5 bg-canteen-50 text-canteen-700 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:bg-gray-50 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
