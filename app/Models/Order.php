<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'is_paid',
        'status',
        'queue_number',
        'order_time',
        'pickup_time',
        'special_notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'is_paid' => 'boolean',
        'order_time' => 'datetime',
        'pickup_time' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Get next queue number for today
    public function getNextQueueNumber(): int
    {
        $today = now()->toDateString();
        
        $maxQueue = Order::whereDate('created_at', $today)
            ->whereNotNull('queue_number')
            ->max('queue_number');

        return ($maxQueue ?? 0) + 1;
    }

    // Check if order can be cancelled
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    // Get status badge color
    public function getStatusColor(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'preparing' => 'orange',
            'ready' => 'green',
            'picked_up' => 'gray',
            'cancelled' => 'red',
            default => 'gray'
        };
    }
}
