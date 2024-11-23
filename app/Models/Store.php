<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
