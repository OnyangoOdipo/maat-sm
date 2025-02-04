<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cubicle extends Model
{
    protected $fillable = [
        'house_id',
        'name',
        'type',
        'capacity',
        'floor_number',
        'maintenance_notes',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function beds(): HasMany
    {
        return $this->hasMany(Bed::class);
    }

    public function getOccupancyAttribute(): int
    {
        return $this->beds()->where('is_occupied', true)->count();
    }
} 