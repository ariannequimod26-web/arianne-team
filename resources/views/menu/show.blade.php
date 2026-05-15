<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('menu.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-xl font-bold text-gray-900">{{ $menuItem->name }}</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Image -->
                    <div class="md:w-1/2">
                        @if($menuItem->image)
                            <img src="{{ Str::startsWith($menuItem->image, ['http://', 'https://']) ? $menuItem->image : asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" class="w-full h-72 md:h-full object-cover">
                        @else
                            <div class="w-full h-72 md:h-full bg-gradient-to-br from-gray-50 to-gray-100 flex flex-col items-center justify-center text-gray-300">
                                <svg class="w-16 h-16 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="font-semibold text-sm text-gray-400">No Image</span>
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="md:w-1/2 p-6 sm:p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-bold uppercase tracking-wider text-canteen-600 bg-canteen-50 px-3 py-1 rounded-lg">{{ $menuItem->category }}</span>
                                <span class="px-3 py-1 rounded-lg text-xs font-bold {{ $menuItem->isAvailable() ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                    {{ $menuItem->getAvailabilityStatus() }}
                                </span>
                            </div>
                            <h3 class="text-3xl font-black text-gray-900 mb-3">{{ $menuItem->name }}</h3>
                            <p class="text-2xl text-canteen-600 font-bold mb-4">₱{{ number_format($menuItem->price, 2) }}</p>
                            <p class="text-gray-500 leading-relaxed mb-6">{{ $menuItem->description }}</p>
                        </div>

                        @if($menuItem->isAvailable())
                            <form action="{{ route('orders.store') }}" method="POST" class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                                @csrf
                                <input type="hidden" name="items[0][menu_item_id]" value="{{ $menuItem->id }}">
                                <div class="flex flex-col gap-4 mb-4">
                                    <div>
                                        <label for="quantity" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Quantity</label>
                                        <input type="number" name="items[0][quantity]" id="quantity" value="1" min="1" class="w-full border-gray-200 focus:ring-canteen-400 focus:border-canteen-400 rounded-xl shadow-sm font-bold text-lg px-4 py-2">
                                    </div>
                                    <div>
                                        <label for="special_notes" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Special Notes <span class="text-gray-300 font-normal normal-case">(optional)</span></label>
                                        <textarea name="special_notes" id="special_notes" rows="2" class="w-full border-gray-200 focus:ring-canteen-400 focus:border-canteen-400 rounded-xl shadow-sm text-sm py-2" placeholder="e.g., No spicy, extra sauce..."></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Payment Method</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label class="relative flex items-center justify-center p-3 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-white has-[:checked]:border-canteen-500 has-[:checked]:bg-canteen-50/50 transition-all group">
                                                <input type="radio" name="payment_method" value="cash" checked class="hidden peer">
                                                <span class="text-sm font-bold text-gray-400 peer-checked:text-canteen-600">💵 Cash</span>
                                            </label>
                                            <label class="relative flex items-center justify-center p-3 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-white has-[:checked]:border-canteen-500 has-[:checked]:bg-canteen-50/50 transition-all group {{ auth()->user()->balance < $menuItem->price ? 'opacity-50 grayscale pointer-events-none' : '' }}">
                                                <input type="radio" name="payment_method" value="wallet" class="hidden peer">
                                                <div class="text-center">
                                                    <span class="block text-sm font-bold text-gray-400 peer-checked:text-canteen-600">💳 Wallet</span>
                                                    <span class="block text-[10px] text-gray-400">Bal: ₱{{ number_format(auth()->user()->balance, 2) }}</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-canteen-500 hover:bg-canteen-600 text-white font-bold py-3.5 px-6 rounded-xl shadow-sm transition flex justify-center items-center gap-2 text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Place Order
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
