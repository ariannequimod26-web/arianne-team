<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <p class="text-xs font-semibold text-canteen-500 uppercase tracking-wider mb-1">Admin Dashboard</p>
                <h2 class="text-2xl font-bold text-gray-900">Command Center</h2>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-gray-50 px-4 py-2 rounded-xl border border-gray-100 flex items-center gap-3 text-sm">
                    <span class="text-gray-400 font-medium">{{ now()->format('H:i:s') }}</span>
                </div>
                <a href="{{ route('admin.menu.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-canteen-500 hover:bg-canteen-600 text-white font-semibold rounded-xl text-sm transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Stock
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Scorecard -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Revenue</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900 tracking-tight">₱{{ number_format($stats['revenue'], 2) }}</p>
                    <p class="text-xs text-green-500 font-medium mt-1">Today's intake</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Orders</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900 tracking-tight">{{ $stats['orders_count'] }}</p>
                    <p class="text-xs text-blue-500 font-medium mt-1">Total completed</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-9 h-9 bg-canteen-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-canteen-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">In Queue</span>
                    </div>
                    <p class="text-3xl font-black text-canteen-600 tracking-tight">{{ $stats['pending_orders'] }}</p>
                    <p class="text-xs text-canteen-500 font-medium mt-1 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-canteen-500 rounded-full animate-ping"></span>
                        Active tickets
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Avg Order</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900 tracking-tight">₱{{ number_format($stats['avg_order_value'], 2) }}</p>
                    <p class="text-xs text-purple-500 font-medium mt-1">Per transaction</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left: Category + Bestsellers -->
                <div class="lg:col-span-8 space-y-8">
                    <!-- Category Distribution -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="text-lg font-bold text-gray-900">Category Performance</h4>
                            <span class="text-xs text-gray-400 font-medium">Today's mix</span>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach(['breakfast', 'lunch', 'snacks', 'drinks'] as $cat)
                                @php 
                                    $sale = $categorySales->firstWhere('category', $cat);
                                    $count = $sale ? $sale->total_sold : 0;
                                    $percent = $stats['orders_count'] > 0 ? round(($count / $stats['orders_count']) * 100) : 0;
                                    $colorMap = ['breakfast' => ['bg-amber-500', 'bg-amber-50'], 'lunch' => ['bg-red-500', 'bg-red-50'], 'snacks' => ['bg-canteen-500', 'bg-canteen-50'], 'drinks' => ['bg-blue-500', 'bg-blue-50']];
                                    $colors = $colorMap[$cat];
                                @endphp
                                <div>
                                    <div class="flex justify-between items-end mb-2">
                                        <p class="text-sm font-semibold text-gray-700 capitalize">{{ $cat }}</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $percent }}%</p>
                                    </div>
                                    <div class="w-full {{ $colors[1] }} h-2.5 rounded-full overflow-hidden">
                                        <div class="{{ $colors[0] }} h-full rounded-full transition-all duration-700" style="width: {{ $percent }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">{{ $count }} units sold</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Bestsellers -->
                    <div class="bg-gray-900 rounded-2xl shadow-xl p-6">
                        <h4 class="text-lg font-bold text-white mb-6">🏆 Top Sellers</h4>
                        <div class="space-y-3">
                            @forelse($topItems as $item)
                                <div class="flex items-center justify-between p-4 rounded-xl hover:bg-white/5 transition">
                                    <div class="flex items-center gap-4">
                                        <span class="text-2xl font-black text-white/20">{{ $loop->iteration }}</span>
                                        <div>
                                            <p class="font-bold text-white">{{ $item->name }}</p>
                                            <p class="text-xs text-white/40">Bestseller</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-black text-white">{{ $item->total_sold }}</p>
                                        <p class="text-xs text-canteen-400 font-medium">units</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-white/30 text-center py-12 font-medium">No sales data yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right: Live Stream + Shortcuts -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Live Feed -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col" style="max-height: 600px;">
                        <div class="p-5 border-b border-gray-50 bg-gray-900 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                <h4 class="text-xs font-semibold text-white uppercase tracking-wider">Live Stream</h4>
                            </div>
                            <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-medium text-white/50 hover:text-white uppercase tracking-wider transition">View all</a>
                        </div>
                        
                        <div class="flex-1 overflow-y-auto scrollbar-hide divide-y divide-gray-50">
                            @forelse($recentSales as $order)
                                <div class="p-4 hover:bg-gray-50/50 transition-colors">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</p>
                                            <p class="font-semibold text-gray-800 text-sm">{{ $order->user->name }}</p>
                                        </div>
                                        <p class="font-bold text-green-600">₱{{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="status-badge status-badge-{{ $order->status }}">
                                            {{ $order->status }}
                                        </span>
                                        <span class="text-xs text-gray-300">#{{ $order->id }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="py-16 text-center text-gray-300">
                                    <p class="text-sm font-medium">No recent orders</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-gray-900 rounded-2xl shadow-xl p-5">
                        <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Quick Access</h4>
                        <div class="space-y-2">
                            <a href="{{ route('admin.menu.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-white/5 hover:bg-canteen-500 transition text-white group">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    <span class="text-sm font-medium">Inventory</span>
                                </div>
                                <svg class="w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                            <a href="{{ route('queue.index') }}" class="flex items-center justify-between p-3 rounded-xl bg-white/5 hover:bg-canteen-500 transition text-white group">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-sm font-medium">Live Kitchen</span>
                                </div>
                                <svg class="w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
