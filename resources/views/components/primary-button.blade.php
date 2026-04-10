<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-canteen-500 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:bg-canteen-600 focus:bg-canteen-600 active:bg-canteen-700 focus:outline-none focus:ring-2 focus:ring-canteen-400 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm']) }}>
    {{ $slot }}
</button>
