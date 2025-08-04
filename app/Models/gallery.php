<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class gallery extends Model
{
    protected $table = 'galleries';
    
    protected $fillable = [
        'booking_id',
        'customer_id',
        'title',
        'description',
        'before_image',
        'after_image',
        'service_type',
        'status',
        'featured',
        'sort_order'
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_ARCHIVED = 'archived';

    public function booking(): BelongsTo
    {
        return $this->belongsTo(booking::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(customer::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(services::class, 'service_type', 'name');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_DRAFT => 'badge-secondary',
            self::STATUS_PUBLISHED => 'badge-success',
            self::STATUS_ARCHIVED => 'badge-warning',
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getBeforeImageUrlAttribute()
    {
        return $this->before_image ? asset('storage/gallery/' . $this->before_image) : null;
    }

    public function getAfterImageUrlAttribute()
    {
        return $this->after_image ? asset('storage/gallery/' . $this->after_image) : null;
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByServiceType($query, $serviceType)
    {
        return $query->where('service_type', $serviceType);
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 150);
    }

    public function getIsPublishedAttribute()
    {
        return $this->status === self::STATUS_PUBLISHED;
    }
}
