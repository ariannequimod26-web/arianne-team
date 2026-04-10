<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">My Orders</h2>
                <p class="text-sm text-gray-500 mt-1">Track and manage all your orders</p>
            </div>
            <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-canteen-500 text-white rounded-xl text-sm font-semibold hover:bg-canteen-600 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                New Order
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($orders->count() > 0)
                <!-- Desktop Table View -->
                <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Order</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg flex items-center justify-center text-xs font-bold
                                                @if($order->status === 'ready') bg-green-50 text-green-600
                                                @elseif($order->status === 'preparing') bg-orange-50 text-orange-600
                                                @elseif($order->status === 'cancelled') bg-red-50 text-red-500
                                                @elseif($order->status === 'pending') bg-amber-50 text-amber-600
                                                @else bg-gray-50 text-gray-500
                                                @endif
                                            ">
                                                #{{ $order->id }}
                                            </div>
                                            <span class="text-sm font-semibold text-gray-800">#{{ $order->id }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-gray-700">{{ $order->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-gray-800">₱{{ number_format($order->total_amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="status-badge status-badge-{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center gap-1 text-sm text-canteen-600 hover:text-canteen-700 font-semibold">
                                            View
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-3">
                    @foreach($orders as $order)
                        <a href="{{ route('orders.show', $order->id) }}" class="block bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center text-xs font-bold
                                        @if($order->status === 'ready') bg-green-50 text-green-600
                                        @elseif($order->status === 'preparing') bg-orange-50 text-orange-600
                                        @elseif($order->status === 'cancelled') bg-red-50 text-red-500
                                        @elseif($order->status === 'pending') bg-amber-50 text-amber-600
                                        @else bg-gray-50 text-gray-500
                                        @endif
                                    ">
                                        #{{ $order->id }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Order #{{ $order->id }}</p>
                                        <p class="text-xs text-gray-400">{{ $order->created_at->format('M d, Y • h:i A') }}</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-gray-800">₱{{ number_format($order->total_amount, 2) }}</span>
                                <span class="status-badge status-badge-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center">
                    <div class="text-5xl mb-4">🍽️</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">No orders yet</h3>
                    <p class="text-gray-400 mb-6">You haven't placed any orders yet. Browse the menu to get started!</p>
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-canteen-500 text-white rounded-xl font-semibold hover:bg-canteen-600 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Browse Menu
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
