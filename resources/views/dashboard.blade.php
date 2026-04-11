<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
               Good Day , {{ Auth::user()->name }}! 👋
            </h2>
            <p class="text-sm text-gray-500 mt-1">Here's what's happening with your account today.</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Total Orders -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Total Orders</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900 tracking-tight">{{ Auth::user()->orders()->count() }}</p>
                    <a href="{{ route('orders.my-orders') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-gray-400 hover:text-gray-600 transition">
                        View all orders
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <!-- Quick Action -->
                <a href="{{ route('menu.index') }}" class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Hungry?</span>
                    </div>
                    <p class="text-lg font-bold text-gray-900">Browse Menu</p>
                    <p class="text-xs text-gray-400 mt-1">Order something delicious today</p>
                </a>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Recent Orders</h3>
                    <a href="{{ route('orders.my-orders') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">View all →</a>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse(Auth::user()->orders()->with('items.menuItem')->latest()->take(5)->get() as $order)
                        <a href="{{ route('orders.show', $order) }}" class="flex items-center justify-between p-5 hover:bg-gray-50/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold
                                    @if($order->status === 'ready') bg-green-50 text-green-600
                                    @elseif($order->status === 'preparing') bg-orange-50 text-orange-600
                                    @elseif($order->status === 'cancelled') bg-red-50 text-red-500
                                    @elseif($order->status === 'pending') bg-amber-50 text-amber-600
                                    @else bg-gray-50 text-gray-500
                                    @endif
                                ">
                                    @if($order->queue_number) #{{ $order->queue_number }} @else #{{ $order->id }} @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $order->items->pluck('menuItem.name')->take(2)->join(', ') }}
                                        @if($order->items->count() > 2)
                                            <span class="text-gray-400">+{{ $order->items->count() - 2 }} more</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-800">₱{{ number_format($order->total_amount, 2) }}</p>
                                <span class="px-2 py-1 rounded text-[10px] font-black uppercase tracking-widest bg-{{ $order->getStatusColor() }}-100 text-{{ $order->getStatusColor() }}-700">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="py-16 text-center">
                            <div class="text-4xl mb-3">🍽️</div>
                            <p class="text-gray-500 font-medium">No orders yet</p>
                            <p class="text-sm text-gray-400 mt-1">Browse the menu to place your first order!</p>
                            <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Browse Menu
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
