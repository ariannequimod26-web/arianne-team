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
            'special_notes' => 'nullable|string|max:500',
            'payment_method' => 'nullable|in:cash,wallet'
        ]);

        $paymentMethod = $validated['payment_method'] ?? 'cash';

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

            // Check availability with requested quantity
            if (!$menuItem->isAvailable($item['quantity'])) {
                $remaining = $menuItem->daily_limit - $menuItem->sold_today;
                $message = $remaining > 0 
                    ? "Only {$remaining} left for {$menuItem->name}!" 
                    : "{$menuItem->name} is sold out!";
                return back()->with('error', $message);
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

        // Wallet Balance Check
        if ($paymentMethod === 'wallet') {
            if (auth()->user()->balance < $totalAmount) {
                return back()->with('error', 'Insufficient wallet balance!');
            }
            auth()->user()->deduct($totalAmount, "Payment for Order #TEMP");
            $order->is_paid = true;
            $order->status = 'confirmed'; // Auto-confirm if paid via wallet
        } else {
            $order->is_paid = false;
        }

        $order->total_amount = $totalAmount;
        $order->save();

        // Update transaction description with real order ID if wallet was used
        if ($paymentMethod === 'wallet') {
            $transaction = auth()->user()->transactions()->latest()->first();
            $transaction->update(['description' => "Payment for Order #{$order->id}"]);
        }

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

        // Refund if paid via wallet
        if ($order->is_paid) {
            auth()->user()->increment('balance', $order->total_amount);
            auth()->user()->transactions()->create([
                'type' => 'refund',
                'amount' => $order->total_amount,
                'description' => "Refund for cancelled Order #{$order->id}",
                'status' => 'completed'
            ]);
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
