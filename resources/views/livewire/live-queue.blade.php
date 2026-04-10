<div wire:poll.10s>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Ready for Pickup -->
        <div class="flex flex-col h-full">
            <div class="bg-green-500 p-5 rounded-t-2xl">
                <div class="flex justify-between items-center text-white">
                    <h3 class="font-bold text-lg">🎉 Ready for Pickup</h3>
                    <span class="bg-white text-green-600 font-bold px-2.5 py-0.5 rounded-full text-sm">{{ count($readyOrders) }}</span>
                </div>
            </div>
            <div class="bg-white flex-1 p-5 rounded-b-2xl shadow-sm border-x border-b border-gray-100 min-h-[350px]">
                <div class="grid grid-cols-2 gap-3">
                    @forelse($readyOrders as $order)
                        <div class="bg-green-50 border border-green-200 text-green-700 p-5 rounded-xl text-center animate-bounce">
                            <p class="text-[10px] font-semibold uppercase tracking-widest opacity-60 mb-1">Token</p>
                            <p class="text-3xl font-black leading-none">#{{ $order->queue_number }}</p>
                        </div>
                    @empty
                        <div class="col-span-2 flex flex-col items-center justify-center py-16 text-gray-300">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="font-semibold text-sm">No orders ready</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Preparing -->
        <div class="flex flex-col h-full">
            <div class="bg-canteen-500 p-5 rounded-t-2xl">
                <div class="flex justify-between items-center text-white">
                    <h3 class="font-bold text-lg">🔥 Preparing</h3>
                    <span class="bg-white text-canteen-600 font-bold px-2.5 py-0.5 rounded-full text-sm">{{ count($preparingOrders) }}</span>
                </div>
            </div>
            <div class="bg-white flex-1 p-5 rounded-b-2xl shadow-sm border-x border-b border-gray-100 min-h-[350px]">
                <div class="grid grid-cols-2 gap-3">
                    @forelse($preparingOrders as $order)
                        <div class="bg-canteen-50 border border-canteen-200 text-canteen-700 p-5 rounded-xl text-center">
                            <p class="text-[10px] font-semibold uppercase tracking-widest opacity-60 mb-1">Token</p>
                            <p class="text-3xl font-black leading-none animate-pulse">#{{ $order->queue_number }}</p>
                        </div>
                    @empty
                        <div class="col-span-2 flex flex-col items-center justify-center py-16 text-gray-300">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <p class="font-semibold text-sm">Kitchen idle</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- History -->
        <div class="flex flex-col h-full">
            <div class="bg-gray-700 p-5 rounded-t-2xl">
                <div class="flex justify-between items-center text-white">
                    <h3 class="font-bold text-lg">✅ Completed</h3>
                    <span class="bg-white/10 text-white font-bold px-2.5 py-0.5 rounded-full text-sm">Recent</span>
                </div>
            </div>
            <div class="bg-white flex-1 p-5 rounded-b-2xl shadow-sm border-x border-b border-gray-100 min-h-[350px]">
                <div class="space-y-3">
                    @forelse($pickedUpOrders->take(6) as $order)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl text-gray-400">
                            <div class="flex items-center gap-3">
                                <p class="text-lg font-bold">#{{ $order->queue_number }}</p>
                                <div>
                                    <p class="text-xs font-medium">Picked up</p>
                                    <p class="text-xs">{{ $order->pickup_time->diffForHumans() }}</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 text-gray-300">
                            <p class="font-semibold text-sm">No recent pickups</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
