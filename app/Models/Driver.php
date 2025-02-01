<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'name',
        'license_number',
        'phone',
        'license_expiry',
        'status',
        'notes'
    ];

    protected $casts = [
        'license_expiry' => 'date'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function routeAssignments(): HasMany
    {
        return $this->hasMany(RouteAssignment::class);
    }
} 