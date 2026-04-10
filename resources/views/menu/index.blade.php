<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Today's Fresh Picks 🍳</h2>
            <p class="text-sm text-gray-500 mt-1">Browse our menu and order your favorites</p>
        </div>
    </x-slot>

    @livewire('menu-index')
</x-app-layout>
