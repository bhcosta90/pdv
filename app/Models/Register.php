<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Concerns\HasUuids, Model, SoftDeletes};

class Register extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'opened_at'  => 'datetime:d/m/Y H:i:s',
        'closed_at'  => 'datetime:d/m/Y H:i:s',
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    public function uniqueIds(): array
    {
        return ['code'];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
