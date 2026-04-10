<div class="py-6" wire:poll.10s>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Column 1: Awaiting Payment -->
        <div class="bg-red-50/30 rounded-2xl border border-red-100/50 p-5">
            <div class="flex items-center justify-between mb-6 px-1">
                <h3 class="text-lg font-bold text-red-600">💳 Pending Payment</h3>
                <span class="bg-red-500 text-white font-bold px-2.5 py-0.5 rounded-full text-xs">{{ count($unpaid) }}</span>
            </div>
            
            <div class="space-y-4">
                @forelse($unpaid as $order)
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="text-xs font-medium text-gray-400 mb-0.5">Order #{{ $order->id }}</p>
                                <p class="font-bold text-gray-800">{{ $order->user->name }}</p>
                            </div>
                            <p class="text-lg font-bold text-red-600">₱{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        
                        <div class="space-y-1 mb-4 text-sm text-gray-500">
                            @foreach($order->items as $item)
                                <div class="flex justify-between">
                                    <span>{{ $item->quantity }}x {{ $item->menuItem->name }}</span>
                                </div>
                            @endforeach
                        </div>

                        <button wire:click="startCooking({{ $order->id }})" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2.5 rounded-xl text-sm transition shadow-sm">
                            Confirm Pay & Start Cooking
                        </button>
                    </div>
                @empty
                    <div class="py-16 text-center text-gray-300 text-sm font-medium">No unpaid orders</div>
                @endforelse
            </div>
        </div>

        <!-- Column 2: Currently Cooking -->
        <div class="bg-blue-50/30 rounded-2xl border border-blue-100/50 p-5">
            <div class="flex items-center justify-between mb-6 px-1">
                <h3 class="text-lg font-bold text-blue-600">🔥 Cooking Now</h3>
                <span class="bg-blue-500 text-white font-bold px-2.5 py-0.5 rounded-full text-xs">{{ count($cooking) }}</span>
            </div>
            
            <div class="space-y-4">
                @forelse($cooking as $order)
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-blue-100">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="text-xs font-medium text-blue-400 mb-0.5">Queue #{{ $order->queue_number }}</p>
                                <p class="font-bold text-gray-800">{{ $order->user->name }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-1 mb-4 text-sm border-l-2 border-blue-100 pl-3">
                            @foreach($order->items as $item)
                                <div class="text-blue-600 font-medium">{{ $item->quantity }}x {{ $item->menuItem->name }}</div>
                                @if($item->notes) <div class="text-xs text-canteen-500 pl-2">📝 {{ $item->notes }}</div> @endif
                            @endforeach
                            @if($order->special_notes)
                                <div class="mt-2 p-2 bg-amber-50 rounded-lg text-xs text-amber-700 border border-amber-100">
                                    📝 {{ $order->special_notes }}
                                </div>
                            @endif
                        </div>

                        <button wire:click="markReady({{ $order->id }})" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 rounded-xl text-sm transition shadow-sm">
                            ✅ Mark Ready for Pickup
                        </button>
                    </div>
                @empty
                    <div class="py-16 text-center text-gray-300 text-sm font-medium">Kitchen idle</div>
                @endforelse
            </div>
        </div>

        <!-- Column 3: Ready for Pickup -->
        <div class="bg-green-50/30 rounded-2xl border border-green-100/50 p-5">
            <div class="flex items-center justify-between mb-6 px-1">
                <h3 class="text-lg font-bold text-green-600">🎉 Ready to Pickup</h3>
                <span class="bg-green-500 text-white font-bold px-2.5 py-0.5 rounded-full text-xs">{{ count($ready) }}</span>
            </div>
            
            <div class="space-y-4">
                @forelse($ready as $order)
                    <div class="bg-green-500 p-5 rounded-xl shadow-sm text-white">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-green-600">
                                <span class="text-xl font-black">#{{ $order->queue_number }}</span>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-green-200 mb-0.5">Ready</p>
                                <p class="font-bold">{{ $order->user->name }}</p>
                            </div>
                        </div>

                        <button wire:click="markPickedUp({{ $order->id }})" class="w-full bg-white text-green-600 font-semibold py-2.5 rounded-xl text-sm transition hover:bg-green-50">
                            Hand Over & Complete
                        </button>
                    </div>
                @empty
                    <div class="py-16 text-center text-gray-300 text-sm font-medium">Nothing ready yet</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
