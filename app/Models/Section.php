<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'curriculum_type_id',
        'name',
        'code',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function curriculumType()
    {
        return $this->belongsTo(CurriculumType::class);
    }

    public function classLevels()
    {
        return $this->hasMany(ClassLevel::class);
    }

    public function classRooms()
    {
        return $this->hasManyThrough(ClassRoom::class, ClassLevel::class);
    }
} 