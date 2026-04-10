<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Live Kitchen Dashboard</h2>
                <p class="text-sm text-gray-500 mt-1">Track your order in real-time</p>
            </div>
            <div class="flex items-center gap-2 text-sm font-medium text-gray-500">
                <span class="w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></span>
                Live Updates
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('live-queue')
        </div>
    </div>
</x-app-layout>
