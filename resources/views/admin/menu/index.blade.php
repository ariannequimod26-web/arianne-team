<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-xs font-semibold text-canteen-500 uppercase tracking-wider mb-1">Admin</p>
                <h2 class="text-2xl font-bold text-gray-900">Menu Management</h2>
            </div>
            <a href="{{ route('admin.menu.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-canteen-500 hover:bg-canteen-600 text-white font-semibold rounded-xl text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Item
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 p-4 mb-6 font-medium rounded-xl text-sm flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b border-gray-100">
                                    <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Item</th>
                                    <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Category</th>
                                    <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Price</th>
                                    <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Status</th>
                                    <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Limit</th>
                                    <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Sold</th>
                                    <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($menuItems as $item)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4">
                                            <div class="flex items-center gap-3">
                                                @if($item->image)
                                                    <img src="{{ Str::startsWith($item->image, ['http://', 'https://']) ? $item->image : asset('storage/' . $item->image) }}" class="w-10 h-10 rounded-lg object-cover">
                                                @else
                                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300 text-xs">N/A</div>
                                                @endif
                                                <span class="font-semibold text-gray-800">{{ $item->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <span class="text-xs font-medium text-gray-500 capitalize bg-gray-50 px-2.5 py-1 rounded-lg">{{ $item->category }}</span>
                                        </td>
                                        <td class="py-4 font-bold text-green-600">₱{{ number_format($item->price, 2) }}</td>
                                        <td class="py-4 text-center">
                                            <span class="inline-block w-2.5 h-2.5 rounded-full {{ $item->available ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        </td>
                                        <td class="py-4 text-center text-sm text-gray-500">{{ $item->daily_limit ?? '∞' }}</td>
                                        <td class="py-4 text-center font-semibold text-blue-600">{{ $item->sold_today }}</td>
                                        <td class="py-4 text-right space-x-2">
                                            <a href="{{ route('admin.menu.edit', $item) }}" class="text-xs font-medium bg-gray-50 hover:bg-gray-100 text-gray-600 py-2 px-3 rounded-lg transition border border-gray-100">Edit</a>
                                            <form action="{{ route('admin.menu.destroy', $item) }}" method="POST" class="inline-block">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-xs font-medium bg-red-50 hover:bg-red-100 text-red-500 py-2 px-3 rounded-lg transition border border-red-100" onclick="return confirm('Delete this item?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $menuItems->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
