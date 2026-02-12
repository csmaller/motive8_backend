<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VelocityClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'schedule',
        'duration',
        'max_participants',
        'current_enrollment',
        'instructor',
        'level',
        'cost',
        'location',
        'equipment',
        'prerequisites'
    ];

    protected $casts = [
        'equipment' => 'array',
        'prerequisites' => 'array',
        'cost' => 'decimal:2'
    ];
}
