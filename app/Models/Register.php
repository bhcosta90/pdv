<?php

declare(strict_types = 1);

namespace App\Models;

use App\Casts\FloatToIntCast;
use App\Facades\BcMathNumberFacade;
use App\Models\Enums\{RegisterHistoryAction, RegisterHistoryType};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Concerns\HasUuids, Model, Relations\HasMany, SoftDeletes};

class Register extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'balance'    => FloatToIntCast::class,
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

    public function registerActivity(float $value, RegisterHistoryAction $action): void
    {
        $valueHistory = abs((float) (string) BcMathNumberFacade::make($value)->sub($this->balance));

        $this->histories()->create([
            'value'  => $valueHistory !== 0.0 ? $valueHistory : null,
            'action' => $action,
            'type'   => match (true) {
                $value > $this->balance => RegisterHistoryType::Credit,
                $value < $this->balance => RegisterHistoryType::Debit,
                default                 => RegisterHistoryType::Success,
            },
        ]);

        if ($this->balance !== $value) {
            $this->balance = $value;
        }
    }

    public function histories(): HasMany
    {
        return $this->hasMany(RegisterHistory::class);
    }
}
