<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolType extends Model
{
    protected $fillable = [
        'school_id',
        'category',
        'name',
        'description'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
} 