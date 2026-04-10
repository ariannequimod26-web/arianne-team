<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('orders.my-orders') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Order #{{ $order->id }}</h2>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $order->order_time->format('M d, Y • h:i A') }}</p>
                </div>
            </div>
            <div class="flex gap-3 items-center">
                <span class="status-badge status-badge-{{ $order->status }} font-bold">
                    @if($order->status === 'pending')
                        ⏳ Pending
                    @elseif($order->status === 'confirmed')
                        ✓ Confirmed
                    @elseif($order->status === 'preparing')
                        🔥 Preparing
                    @elseif($order->status === 'ready')
                        🎉 Ready for Pickup
                    @elseif($order->status === 'picked_up')
                        ✅ Completed
                    @elseif($order->status === 'cancelled')
                        ❌ Cancelled
                    @else
                        {{ ucfirst($order->status) }}
                    @endif
                </span>
                @if($order->is_paid)
                    <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-lg border border-green-200">
                        💳 Paid
                    </span>
                @else
                    <span class="text-xs text-red-600 bg-red-50 px-2 py-1 rounded-lg border border-red-200 animate-pulse">
                        Pay at Counter
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <!-- Queue & Customer Info -->
                    <div class="flex flex-col md:flex-row justify-between items-start mb-8 pb-8 border-b border-gray-100">
                        <div class="flex items-center gap-6">
                            @if($order->queue_number)
                                <div class="bg-canteen-50 border border-canteen-200 px-6 py-4 rounded-2xl text-center">
                                    <p class="text-[10px] font-bold text-canteen-400 uppercase tracking-widest mb-1">Queue</p>
                                    <p class="text-4xl font-black text-canteen-600 leading-none">#{{ $order->queue_number }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Customer</p>
                                <p class="text-xl font-bold text-gray-800">{{ $order->user->name }}</p>
                                <p class="text-sm text-gray-400">{{ $order->user->student_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="text-right mt-6 md:mt-0">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Placed at</p>
                            <p class="text-lg font-bold text-gray-800">{{ $order->order_time->format('h:i A') }}</p>
                            <p class="text-sm text-gray-400">{{ $order->order_time->format('M d, Y') }}</p>
                            @if($order->pickup_time)
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <p class="text-xs font-semibold text-green-500 uppercase tracking-wider mb-1">Picked up</p>
                                    <p class="text-lg font-bold text-green-600">{{ $order->pickup_time->format('h:i A') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-8">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Order Summary</h3>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center font-bold text-sm text-gray-500 border border-gray-100">
                                            {{ $item->quantity }}x
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $item->menuItem->name }}</p>
                                            <p class="text-xs text-gray-400">₱{{ number_format($item->price, 2) }} each</p>
                                        </div>
                                    </div>
                                    <p class="font-bold text-gray-800">₱{{ number_format($item->getSubtotal(), 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 flex justify-between items-center px-4">
                            <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Total</p>
                            <p class="text-3xl font-black text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>

                    @if($order->special_notes)
                        <div class="mb-8 p-4 bg-amber-50 rounded-xl border border-amber-100">
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Special Notes</p>
                            </div>
                            <p class="text-sm text-amber-800">{{ $order->special_notes }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100">
                        @if($order->canBeCancelled())
                            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full px-5 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-xl transition border border-red-100 text-sm" onclick="return confirm('Are you sure you want to cancel this order?')">
                                    Cancel Order
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('menu.index') }}" class="flex-1 flex items-center justify-center gap-2 px-5 py-3 bg-canteen-500 hover:bg-canteen-600 text-white font-semibold rounded-xl transition text-sm shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Order Something Else
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
