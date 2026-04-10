<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <p class="text-xs font-semibold text-canteen-500 uppercase tracking-wider mb-1">Kitchen Operations</p>
                <h2 class="text-2xl font-bold text-gray-900">Order Fulfillment</h2>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                <span class="font-medium">Live Kitchen Stream</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-[100rem] mx-auto sm:px-6 lg:px-8">
            @livewire('kitchen-board')
        </div>
    </div>
</x-app-layout>
