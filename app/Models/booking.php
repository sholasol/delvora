<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class booking extends Model
{
    protected $table = 'bookings';
    
    protected $fillable = [
        'customer_id',
        'service_id', 
        'service_name',
        'preferred_date',
        'preferred_time',
        'name',
        'email',
        'phone',
        'address',
        'message',
        'status',
        'total_amount',
        'payment_status',
        'booking_reference',
        'special_instructions'
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Payment status constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_PARTIAL = 'partial';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(customer::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(services::class);
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }

    public function gallery()
    {
        return $this->hasMany(gallery::class);
    }

    public static function generateBookingReference()
    {
        return 'BK-' . date('Ymd') . '-' . strtoupper(uniqid());
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_PENDING => 'badge-warning',
            self::STATUS_CONFIRMED => 'badge-info',
            self::STATUS_IN_PROGRESS => 'badge-primary',
            self::STATUS_COMPLETED => 'badge-success',
            self::STATUS_CANCELLED => 'badge-danger',
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            self::PAYMENT_PENDING => 'badge-warning',
            self::PAYMENT_PAID => 'badge-success',
            self::PAYMENT_PARTIAL => 'badge-info',
        ];

        return $badges[$this->payment_status] ?? 'badge-secondary';
    }

    public function getFormattedTotalAmountAttribute()
    {
        return '$' . number_format($this->total_amount, 2);
    }

    public function getFormattedPreferredDateAttribute()
    {
        return $this->preferred_date ? $this->preferred_date->format('M d, Y') : 'Not set';
    }

    public function getFormattedPreferredTimeAttribute()
    {
        return $this->preferred_time ? date('g:i A', strtotime($this->preferred_time)) : 'Not set';
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }
}
