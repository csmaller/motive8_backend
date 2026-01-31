<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'bio',
        'image',
        'experience_years',
        'certification'
    ];

    protected $appends = ['image_url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specializations(): HasMany
    {
        return $this->hasMany(PersonSpecialization::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return Storage::disk('public')->url($this->image);
    }
}
