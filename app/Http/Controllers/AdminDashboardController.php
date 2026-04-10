<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $this->authorize('admin');
        $today = today();

        // Only count completed (picked_up) orders for revenue
        $completedStatuses = ['picked_up'];
        
        $stats = [
            'revenue' => Order::whereDate('created_at', $today)
                ->whereIn('status', $completedStatuses)
                ->sum('total_amount'),
            'orders_count' => Order::whereDate('created_at', $today)
                ->whereIn('status', $completedStatuses)
                ->count(),
            'pending_orders' => Order::whereDate('created_at', $today)
                ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
                ->count(),
            'avg_order_value' => Order::whereDate('created_at', $today)
                ->whereIn('status', $completedStatuses)
                ->avg('total_amount') ?? 0,
        ];

        // Top items from completed orders only
        $topItems = DB::table('order_items')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->whereDate('order_items.created_at', $today)
            ->whereIn('orders.status', $completedStatuses)
            ->groupBy('menu_items.id', 'menu_items.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $recentSales = Order::with('user')
            ->whereIn('status', $completedStatuses)
            ->latest()
            ->take(5)
            ->get();

        // Category sales from completed orders only
        $categorySales = DB::table('order_items')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('menu_items.category', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->whereDate('order_items.created_at', $today)
            ->whereIn('orders.status', $completedStatuses)
            ->groupBy('menu_items.category')
            ->get();

        return view('admin.dashboard', compact('stats', 'topItems', 'recentSales', 'categorySales'));
    }
}
