<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonSpecialization extends Model
{
    use HasFactory;

    protected $table = 'person_specializations';

    protected $fillable = [
        'person_id',
        'specialization',
        'description'
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
