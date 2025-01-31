<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'section_id',
        'class_level_id',
        'stream',
        'capacity',
        'teacher_id',
        'room_number',
        'status',
        'notes'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
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
        return $this->hasMany(Student::class);
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