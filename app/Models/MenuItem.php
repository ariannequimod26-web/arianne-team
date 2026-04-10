<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'available',
        'daily_limit',
        'sold_today'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'available' => 'boolean',
    ];

    // Relationships
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Check if item is available for ordering
    public function isAvailable(): bool
    {
        if (!$this->available) {
            return false;
        }

        if ($this->daily_limit && $this->sold_today >= $this->daily_limit) {
            return false;
        }

        return true;
    }

    // Get availability status message
    public function getAvailabilityStatus(): string
    {
        if (!$this->available) {
            return 'Not Available';
        }

        if ($this->daily_limit) {
            $remaining = $this->daily_limit - $this->sold_today;
            return "Only {$remaining} left";
        }

        return 'Available';
    }
}
