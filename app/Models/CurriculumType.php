<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'school_id',
        // ... any other existing fillable attributes ...
    ];
}
