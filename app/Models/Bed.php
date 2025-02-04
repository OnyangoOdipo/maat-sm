<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bed extends Model
{
    protected $fillable = [
        'cubicle_id',
        'bed_number',
        'is_occupied',
        'needs_maintenance',
        'maintenance_notes'
    ];

    protected $casts = [
        'is_occupied' => 'boolean',
        'needs_maintenance' => 'boolean'
    ];

    public function cubicle(): BelongsTo
    {
        return $this->belongsTo(Cubicle::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(BedAssignment::class);
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(BedAssignment::class)->whereNull('end_date');
    }
} 