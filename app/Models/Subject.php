<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'code',
        'subject_type',
        'status'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subjects')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    public function classLevels()
    {
        return $this->belongsToMany(ClassLevel::class, 'class_level_subjects')
            ->withPivot('lessons_per_week', 'is_compulsory')
            ->withTimestamps();
    }

    public function timetableSlots()
    {
        return $this->hasMany(TimetableSlot::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCore($query)
    {
        return $query->where('subject_type', 'core');
    }

    public function scopeElective($query)
    {
        return $query->where('subject_type', 'elective');
    }
}