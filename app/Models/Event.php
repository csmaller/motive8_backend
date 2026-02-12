<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'time',
        'location',
        'description',
        'type',
        'registration_required',
        'max_participants',
        'current_participants',
        'registration_deadline',
        'cost',
        'image_url',
        'payment_url'
    ];

    protected $casts = [
        'date' => 'date',
        'registration_deadline' => 'date',
        'registration_required' => 'boolean',
        'cost' => 'decimal:2'
    ];
}
