<?php

namespace App\Livewire;

use App\Models\Order;
use App\Events\OrderStatusUpdated;
use Livewire\Component;
use Livewire\Attributes\On;

class KitchenBoard extends Component
{
    #[On('echo:queue,OrderStatusUpdated')]
    public function refreshBoard()
    {
        // Automatically refreshes when any status is updated by someone else
    }

    public function markPaid($orderId)
    {
        $order = Order::find($orderId);
        $order->update(['is_paid' => true]);
        $this->dispatch('refreshBoard');
    }

    public function startCooking($orderId)
    {
        $order = Order::find($orderId);
        $queueNumber = $order->getNextQueueNumber();
        $order->update([
            'status' => 'preparing',
            'queue_number' => $queueNumber,
            'is_paid' => true // Auto-paid if staff starts cooking (fallback)
        ]);
        event(new OrderStatusUpdated($order));
    }

    public function markReady($orderId)
    {
        $order = Order::find($orderId);
        $order->update(['status' => 'ready']);
        event(new OrderStatusUpdated($order));
    }

    public function markPickedUp($orderId)
    {
        $order = Order::find($orderId);
        $order->update(['status' => 'picked_up', 'pickup_time' => now()]);
        event(new OrderStatusUpdated($order));
    }

    public function render()
    {
        $orders = Order::whereDate('created_at', today())
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->with(['user', 'items.menuItem'])
            ->orderBy('id', 'asc')
            ->get();

        $unpaid = $orders->where('is_paid', false)->where('status', '!=', 'cancelled');
        $cooking = $orders->where('status', 'preparing');
        $ready = $orders->where('status', 'ready');

        return view('livewire.kitchen-board', compact('unpaid', 'cooking', 'ready'));
    }
}
