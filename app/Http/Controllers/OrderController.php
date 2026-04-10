<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        // auth middleware is applied in routes
    }

    // Show order creation form
    public function create()
    {
        $menuItems = MenuItem::where('available', true)->get();
        
        return view('orders.create', compact('menuItems'));
    }

    // Store new order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'special_notes' => 'nullable|string|max:500'
        ]);

        // Create order
        $order = new Order();
        $order->user_id = auth()->id();
        $order->order_time = now();
        $order->special_notes = $validated['special_notes'] ?? null;
        $order->status = 'pending';

        $totalAmount = 0;
        $orderItems = [];

        // Process each item
        foreach ($validated['items'] as $item) {
            $menuItem = MenuItem::findOrFail($item['menu_item_id']);

            // Check availability
            if (!$menuItem->isAvailable()) {
                return back()->with('error', "{$menuItem->name} is not available!");
            }

            $itemTotal = $menuItem->price * $item['quantity'];
            $totalAmount += $itemTotal;

            $orderItems[] = [
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity'],
                'price' => $menuItem->price
            ];

            // Update sold count
            $menuItem->increment('sold_today', $item['quantity']);
        }

        $order->total_amount = $totalAmount;
        $order->is_paid = false;
        $order->save();

        // Create order items
        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully!');
    }

    // Show order details
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    // Show user's orders
    public function myOrders()
    {
        $orders = auth()->user()->orders()
            ->latest()
            ->paginate(10);

        return view('orders.my-orders', compact('orders'));
    }

    // Cancel order
    public function cancel(Order $order)
    {
        $this->authorize('update', $order);

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Cannot cancel this order!');
        }

        // Revert sold count
        foreach ($order->items as $item) {
            $item->menuItem->decrement('sold_today', $item->quantity);
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully!');
    }

    // Admin/Staff: View all orders
    public function adminIndex()
    {
        $this->authorize('staff');

        $orders = Order::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }
}
