<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;

class LiveQueue extends Component
{
    #[On('echo:queue,OrderStatusUpdated')]
    public function refreshQueue()
    {
        // Livewire automatically refreshes the component when this is called
    }

    public function render()
    {
        $todayOrders = Order::whereDate('created_at', today())
            ->whereNotNull('queue_number')
            ->orderBy('queue_number', 'desc')
            ->get();

        $readyOrders = $todayOrders->where('status', 'ready');
        $preparingOrders = $todayOrders->where('status', 'preparing');
        $pickedUpOrders = $todayOrders->where('status', 'picked_up');

        return view('livewire.live-queue', compact(
            'readyOrders',
            'preparingOrders',
            'pickedUpOrders'
        ));
    }
}
