<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, SoftDeletes};

class Store extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
