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

    public function changeBalance(float $value, RegisterHistoryAction $action): void
    {
        $this->histories()->create([
            'value'  => abs((float) (string) BcMathNumberFacade::make($value)->sub($this->balance)),
            'action' => $action,
            'type'   => $value > $this->balance
                ? RegisterHistoryType::Credit
                : RegisterHistoryType::Debit,
        ]);

        $this->balance = $value;
    }

    public function histories(): HasMany
    {
        return $this->hasMany(RegisterHistory::class);
    }
}
