<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    // Display queue status
    public function index()
    {
        $todayOrders = Order::whereDate('created_at', today())
            ->orderBy('queue_number')
            ->get();

        $readyOrders = $todayOrders->where('status', 'ready');
        $pickedUpOrders = $todayOrders->where('status', 'picked_up');
        $preparingOrders = $todayOrders->where('status', 'preparing');

        return view('queue.index', compact(
            'readyOrders',
            'pickedUpOrders',
            'preparingOrders',
            'todayOrders'
        ));
    }

    // Assign queue number (staff only)
    public function assignQueue(Order $order)
    {
        $this->authorize('staff');

        if ($order->queue_number) {
            return back()->with('error', 'Queue number already assigned!');
        }

        $queueNumber = $order->getNextQueueNumber();
        $order->update([
            'queue_number' => $queueNumber,
            'status' => 'confirmed'
        ]);

        event(new \App\Events\OrderStatusUpdated($order));

        return back()->with('success', "Queue number {$queueNumber} assigned!");
    }

    // Confirm Payment (staff only)
    public function confirmPayment(Order $order)
    {
        $this->authorize('staff');
        $order->update(['is_paid' => true]);
        return back()->with('success', 'Payment confirmed!');
    }

    // Update order status (staff only)
    public function updateStatus(Order $order, Request $request)
    {
        $this->authorize('staff');

        $validated = $request->validate([
            'status' => 'required|in:preparing,ready,picked_up'
        ]);

        $order->update([
            'status' => $validated['status'],
            'pickup_time' => $validated['status'] === 'picked_up' 
                ? now() 
                : $order->pickup_time
        ]);

        event(new \App\Events\OrderStatusUpdated($order));

        return back()->with('success', 'Order status updated!');
    }

    // Get queue statistics
    public function stats()
    {
        $today = today();

        $stats = [
            'total_orders' => Order::whereDate('created_at', $today)->count(),
            'pending' => Order::whereDate('created_at', $today)
                ->where('status', 'pending')->count(),
            'preparing' => Order::whereDate('created_at', $today)
                ->where('status', 'preparing')->count(),
            'ready' => Order::whereDate('created_at', $today)
                ->where('status', 'ready')->count(),
            'picked_up' => Order::whereDate('created_at', $today)
                ->where('status', 'picked_up')->count(),
            'total_revenue' => Order::whereDate('created_at', $today)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount'),
        ];

        return view('queue.stats', compact('stats'));
    }
}
