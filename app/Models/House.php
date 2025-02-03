<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'gender',
        'description',
        'total_capacity',
        'house_parent_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function houseParent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'house_parent_id');
    }

    public function cubicles(): HasMany
    {
        return $this->hasMany(Cubicle::class);
    }
} 