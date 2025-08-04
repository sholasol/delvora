<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $table = 'staff';
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'department',
        'hire_date',
        'status',
        'employee_id',
        'address',
        'emergency_contact',
        'skills',
        'hourly_rate',
        'avatar'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'hourly_rate' => 'decimal:2',
    ];

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_ON_LEAVE = 'on_leave';
    const STATUS_TERMINATED = 'terminated';

    public function bookings(): HasMany
    {
        return $this->hasMany(booking::class, 'assigned_staff_id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(gallery::class, 'staff_id');
    }

    public static function generateEmployeeId()
    {
        return 'EMP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_ACTIVE => 'badge-success',
            self::STATUS_INACTIVE => 'badge-secondary',
            self::STATUS_ON_LEAVE => 'badge-warning',
            self::STATUS_TERMINATED => 'badge-danger',
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/staff/' . $this->avatar) : asset('assets/images/default-avatar.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function getFormattedHourlyRateAttribute()
    {
        return '$' . number_format($this->hourly_rate, 2) . '/hr';
    }

    public function getTotalBookingsAttribute()
    {
        return $this->bookings()->count();
    }

    public function getCompletedBookingsAttribute()
    {
        return $this->bookings()->where('status', booking::STATUS_COMPLETED)->count();
    }

    public function getFormattedHireDateAttribute()
    {
        return $this->hire_date ? $this->hire_date->format('M d, Y') : 'Not set';
    }

    public function getIsActiveAttribute()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    public function getSkillsArrayAttribute()
    {
        return $this->skills ? explode(', ', $this->skills) : [];
    }
} 