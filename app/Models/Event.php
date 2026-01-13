<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'start_end_time',
        'details',
        'sub_title'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];
}
