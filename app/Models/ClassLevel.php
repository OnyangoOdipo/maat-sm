<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'section_id',
        'name',
        'numeric_value',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function classrooms()
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_level_subjects')
            ->withPivot('lessons_per_week', 'is_compulsory')
            ->withTimestamps();
    }

    public function timeslots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    // Helper method to get compulsory subjects
    public function getCompulsorySubjects()
    {
        return $this->subjects()
            ->wherePivot('is_compulsory', true)
            ->get();
    }
}