<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timetable extends Model
{
    protected $fillable = [
        'school_id',
        'class_level_id',
        'term',
        'academic_year',
        'is_active'
    ];

    public function classLevel(): BelongsTo
    {
        return $this->belongsTo(ClassLevel::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(TimetableSlot::class);
    }
} 