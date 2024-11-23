<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Register extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
