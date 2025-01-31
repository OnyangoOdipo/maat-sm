<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'school_id',
        'description',
        'subject_type', // core, elective, optional
        'status',
        'notes'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function curriculumTypes()
    {
        return $this->belongsToMany(CurriculumType::class, 'curriculum_type_subject')
            ->withPivot('is_compulsory')
            ->withTimestamps();
    }

    public function classLevels()
    {
        return $this->belongsToMany(ClassLevel::class, 'class_level_subject')
            ->withPivot('is_compulsory')
            ->withTimestamps();
    }

    public function classRooms()
    {
        return $this->belongsToMany(ClassRoom::class, 'class_room_subject')
            ->withPivot('teacher_id', 'is_compulsory')
            ->withTimestamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher')
            ->withTimestamps();
    }
} 