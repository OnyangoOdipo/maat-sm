<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $table = 'timeslots';

    protected $fillable = [
        'school_id',
        'class_level_id',
        'day',
        'start_time',
        'end_time',
        'type',
        'slot_number',
        'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }

    // Helper Methods
    public function getDurationInMinutes()
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }

    public function isBreak()
    {
        return in_array($this->type, ['break', 'lunch']);
    }
} 