<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'classrooms';

    protected $fillable = [
        'school_id',
        'class_level_id',
        'stream',
        'capacity',
        'room_number',
        'teacher_id',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
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

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'classroom_id');
    }

    public function timetableSlots()
    {
        return $this->hasMany(TimetableSlot::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Helper Methods
    public function getFullNameAttribute()
    {
        return $this->classLevel->name . ' ' . $this->stream;
    }
}