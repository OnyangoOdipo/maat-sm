<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteStop extends Model
{
    protected $fillable = [
        'route_id',
        'name',
        'morning_time',
        'evening_time',
        'sequence'
    ];

    protected $casts = [
        'morning_time' => 'datetime',
        'evening_time' => 'datetime',
        'sequence' => 'integer'
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }
} 