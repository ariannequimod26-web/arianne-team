<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Search & Filter Bar -->
        <div class="mb-10 flex flex-col md:flex-row gap-4 items-center justify-between bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <div class="relative w-full md:w-1/3">
                <svg class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search for your favorites..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-canteen-400/20 focus:border-canteen-400 transition-all text-sm font-medium text-gray-700">
            </div>
            
            <div class="flex flex-wrap gap-2 justify-center">
                @foreach($categories as $category)
                    <button wire:click="selectCategory('{{ $category }}')" class="px-5 py-2.5 rounded-xl text-xs font-semibold uppercase tracking-wider transition-all {{ $selectedCategory === $category ? 'bg-canteen-500 text-white shadow-sm' : 'bg-gray-50 text-gray-500 hover:bg-gray-100 border border-gray-100' }}">
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        </div>

        @forelse($menu as $categoryName => $items)
            <div class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 capitalize">{{ $categoryName }}</h3>
                    <div class="h-px flex-1 bg-gray-100"></div>
                    <span class="text-xs text-gray-400 font-medium">{{ count($items) }} items</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($items as $item)
                        <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 hover:-translate-y-1">
                            <div class="relative h-52 overflow-hidden">
                                @if($item->image)
                                    <img src="{{ Str::startsWith($item->image, ['http://', 'https://']) ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-50 to-gray-100 flex flex-col items-center justify-center text-gray-300 group-hover:from-canteen-50 group-hover:to-orange-50 transition-colors">
                                        <svg class="w-12 h-12 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="font-semibold text-xs text-gray-400">No Preview</span>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-xl shadow-sm">
                                    <span class="text-canteen-600 font-bold">₱{{ number_format($item->price, 2) }}</span>
                                </div>
                            </div>
                            
                            <div class="p-5">
                                <h4 class="text-lg font-bold text-gray-800 mb-1">{{ $item->name }}</h4>
                                <p class="text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                                
                                <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                    <div>
                                        <span class="text-xs font-semibold {{ $item->isAvailable() ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $item->getAvailabilityStatus() }}
                                        </span>
                                    </div>
                                    
                                    @if($item->isAvailable())
                                        <a href="{{ route('menu.show', ['menu' => $item->id]) }}" class="inline-flex items-center gap-1.5 bg-canteen-500 hover:bg-canteen-600 text-white font-semibold px-4 py-2 rounded-xl transition-all text-sm shadow-sm">
                                            Order
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium bg-gray-50 px-3 py-1.5 rounded-lg">Sold Out</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="py-24 text-center bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="text-5xl mb-4">🍽️</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">No Munchies Found</h3>
                <p class="text-gray-400">Try searching for something else!</p>
            </div>
        @endforelse
    </div>
</div>
