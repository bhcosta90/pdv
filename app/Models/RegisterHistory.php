<?php

declare(strict_types = 1);

namespace App\Models;

use App\Casts\FloatToIntCast;
use App\Models\Enums\{RegisterHistoryAction, RegisterHistoryType};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class RegisterHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'value',
        'type',
        'action',
    ];

    protected $casts = [
        'type'   => RegisterHistoryType::class,
        'action' => RegisterHistoryAction::class,
        'value'  => FloatToIntCast::class,
    ];

    public function register(): BelongsTo
    {
        return $this->belongsTo(Register::class);
    }
}
