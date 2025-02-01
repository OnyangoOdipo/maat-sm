<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'school_id',
        'class_level_id',
        'term',
        'academic_year',
        'is_active'
    ];

    public function slots()
    {
        return $this->hasMany(TimetableSlot::class);
    }

    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }
} 