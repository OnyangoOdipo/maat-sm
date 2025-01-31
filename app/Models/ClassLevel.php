<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'name',
        'numeric_value',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, ClassRoom::class);
    }

    // Helper Methods
    public function getFullNameAttribute()
    {
        return $this->section->name . ' - ' . $this->name;
    }
} 