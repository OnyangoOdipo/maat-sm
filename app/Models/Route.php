<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'name',
        'description',
        'morning_pickup_time',
        'evening_departure_time',
        'fee_amount',
        'is_active'
    ];

    protected $casts = [
        'morning_pickup_time' => 'datetime',
        'evening_departure_time' => 'datetime',
        'fee_amount' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function stops(): HasMany
    {
        return $this->hasMany(RouteStop::class)->orderBy('sequence');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(RouteAssignment::class);
    }
} 