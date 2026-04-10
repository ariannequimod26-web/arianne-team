<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display the student-facing menu.
     */
    public function studentIndex()
    {
        $categories = ['breakfast', 'lunch', 'snacks', 'drinks'];
        
        // Get available items grouped by category
        $menu = MenuItem::where('available', true)
            ->get()
            ->groupBy('category');

        return view('menu.index', compact('menu', 'categories'));
    }

    /**
     * Admin: List all menu items for management.
     */
    public function index()
    {
        $this->authorize('admin');
        
        $menuItems = MenuItem::paginate(15);
        return view('admin.menu.index', compact('menuItems'));
    }

    // Show single menu item details
    public function show(MenuItem $menu)
    {
        $menuItem = $menu;
        return view('menu.show', compact('menuItem'));
    }

    // Admin: Create menu item form
    public function create()
    {
        $this->authorize('admin');
        return view('admin.menu.create');
    }

    // Admin: Store new menu item
    public function store(Request $request)
    {
        $this->authorize('admin');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:breakfast,lunch,snacks,drinks',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'daily_limit' => 'nullable|integer|min:1',
            'available' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu-items', 'public');
            $validated['image'] = $path;
        }

        MenuItem::create($validated);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu item created successfully!');
    }

    // Admin: Edit menu item form
    public function edit(MenuItem $menu)
    {
        $this->authorize('admin');
        $menuItem = $menu;
        return view('admin.menu.edit', compact('menuItem'));
    }

    // Admin: Update menu item
    public function update(Request $request, MenuItem $menu)
    {
        $this->authorize('admin');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:breakfast,lunch,snacks,drinks',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'daily_limit' => 'nullable|integer|min:1',
            'available' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu-items', 'public');
            $validated['image'] = $path;
        }

        $menu->update($validated);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu item updated successfully!');
    }

    // Admin: Delete menu item
    public function destroy(MenuItem $menu)
    {
        $this->authorize('admin');
        $menu->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu item deleted successfully!');
    }
}
