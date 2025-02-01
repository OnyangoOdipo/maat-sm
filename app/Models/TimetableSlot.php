<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimetableSlot extends Model
{
    protected $fillable = [
        'timetable_id',
        'timeslot_id',
        'subject_id',
        'teacher_id',
        'classroom_id'
    ];

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }

    public function timeslot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
} 