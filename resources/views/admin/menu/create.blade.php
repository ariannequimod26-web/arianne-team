<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold text-canteen-500 uppercase tracking-wider mb-1">Stock Management</p>
            <h2 class="text-2xl font-bold text-gray-900">Create New Menu Item</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Item Name</label>
                            <input type="text" name="name" required class="w-full border-gray-200 focus:ring-canteen-400 focus:border-canteen-400 rounded-xl" placeholder="e.g., Spicy Adobo">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                            <select name="category" class="w-full border-gray-200 focus:ring-canteen-400 focus:border-canteen-400 rounded-xl">
                                <option value="breakfast">Breakfast</option>
                                <option value="lunch">Lunch</option>
                                <option value="snacks">Snacks</option>
                                <option value="drinks">Drinks</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Price (₱)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">₱</span>
                                <input type="number" name="price" step="0.01" required class="w-full pl-8 border-gray-200 focus:ring-canteen-400 focus:border-canteen-400 rounded-xl" placeholder="0.00">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full border-gray-200 focus:ring-canteen-400 focus:border-canteen-400 rounded-xl" placeholder="Tell students about this dish..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Daily Limit</label>
                            <input type="number" name="daily_limit" class="w-full border-gray-200 focus:ring-canteen-400 focus:border-canteen-400 rounded-xl" placeholder="e.g., 50 (leave empty for unlimited)">
                        </div>

                        <div class="flex items-center">
                            <label class="inline-flex items-center cursor-pointer mt-6">
                                <input type="checkbox" name="available" value="1" checked class="rounded border-gray-300 text-canteen-600 focus:ring-canteen-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 uppercase tracking-wider">Available for Order</span>
                            </label>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Product Image</label>
                            <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-50 flex gap-3">
                        <button type="submit" class="flex-1 bg-canteen-500 hover:bg-canteen-600 text-white font-bold py-3 rounded-xl shadow-sm transition">
                            Save Item
                        </button>
                        <a href="{{ route('admin.menu.index') }}" class="px-8 bg-gray-50 hover:bg-gray-100 text-gray-500 font-bold py-3 rounded-xl transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
