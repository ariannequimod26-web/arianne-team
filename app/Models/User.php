<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'student_id',
        'balance',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function topUp($amount, $description = 'Top up')
    {
        $this->increment('balance', $amount);
        return $this->transactions()->create([
            'type' => 'topup',
            'amount' => $amount,
            'description' => $description
        ]);
    }

    public function deduct($amount, $description = 'Payment')
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient balance');
        }
        $this->decrement('balance', $amount);
        return $this->transactions()->create([
            'type' => 'payment',
            'amount' => $amount,
            'description' => $description
        ]);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Check if user is admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Check if user is staff
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    // Check if user is student
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}
