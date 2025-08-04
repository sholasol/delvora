<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class customer extends Model
{
    protected $table = 'customers';
    
    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'address', 
        'message',
        'status',
        'customer_reference',
        'total_bookings',
        'total_spent',
        'last_booking_date'
    ];

    protected $casts = [
        'total_spent' => 'decimal:2',
        'last_booking_date' => 'date',
    ];

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BLOCKED = 'blocked';

    public function bookings(): HasMany
    {
        return $this->hasMany(booking::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(gallery::class);
    }

    public static function generateCustomerReference()
    {
        return 'CUST-' . date('Ymd') . '-' . strtoupper(uniqid());
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_ACTIVE => 'badge-success',
            self::STATUS_INACTIVE => 'badge-secondary',
            self::STATUS_BLOCKED => 'badge-danger',
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getTotalBookingsAttribute()
    {
        return $this->bookings()->count();
    }

    public function getTotalSpentAttribute()
    {
        return $this->bookings()->sum('total_amount');
    }

    public function getLastBookingDateAttribute()
    {
        $lastBooking = $this->bookings()->latest()->first();
        return $lastBooking ? $lastBooking->created_at : null;
    }

    public function getFormattedTotalSpentAttribute()
    {
        return '$' . number_format($this->total_spent ?? 0, 2);
    }

    public function getFormattedLastBookingDateAttribute()
    {
        return $this->last_booking_date ? $this->last_booking_date->format('M d, Y') : 'No bookings';
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    public function scopeBlocked($query)
    {
        return $query->where('status', self::STATUS_BLOCKED);
    }
}
