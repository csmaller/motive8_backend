<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserType extends Model
{
    use HasFactory;

    protected $table = 'user_type';

    protected $fillable = ['type'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_type_id');
    }
}
