<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BedAssignment extends Model
{
    protected $fillable = [
        'bed_id',
        'student_id',
        'assigned_date',
        'end_date',
        'notes'
    ];

    protected $casts = [
        'assigned_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function bed(): BelongsTo
    {
        return $this->belongsTo(Bed::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
} 