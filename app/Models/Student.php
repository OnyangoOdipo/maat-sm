<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'school_id',
        'classroom_id',
        'admission_number',
        'roll_number',
        'date_of_birth',
        'gender',
        'address',
        'phone',
        'parent_name',
        'parent_phone',
        'parent_email',
        'parent_occupation',
        'parent_relationship',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'medical_conditions',
        'allergies',
        'blood_group',
        'admission_date',
        'status',
        'previous_school',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassRoom::class, 'classroom_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    // Accessors & Mutators
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth->age;
    }

    // Helper Methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function markAsInactive()
    {
        $this->update(['status' => 'inactive']);
    }

    public function graduate()
    {
        $this->update(['status' => 'graduated']);
    }

    public function transfer()
    {
        $this->update(['status' => 'transferred']);
    }
}
