<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class services extends Model
{
    protected $table = 'services';
    
    protected $fillable = [
        'name', 
        'description', 
        'image', 
        'price',
        'duration', 
        'status', 
        'include', 
        'exclude',
        'category',
        'featured',
        'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'featured' => 'boolean',
    ];

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DRAFT = 'draft';

    public function bookings(): HasMany
    {
        return $this->hasMany(booking::class, 'service_id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(gallery::class, 'service_type', 'name');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_ACTIVE => 'badge-success',
            self::STATUS_INACTIVE => 'badge-secondary',
            self::STATUS_DRAFT => 'badge-warning',
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/services/' . $this->image) : asset('assets/images/default-service.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getFormattedDurationAttribute()
    {
        return $this->duration . ' hours';
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 100);
    }

    public function getIsActiveAttribute()
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
