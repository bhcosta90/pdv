<?php

declare(strict_types = 1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class StoreRule implements ValidationRule
{
    public function __construct(protected string $table, protected int $store, protected $column = 'id')
    {
        //
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table($this->table)
            ->where($this->column, $value)
            ->where('store_id', $this->store)
            ->exists();

        if (!$exists) {
            $fail('The selected ' . $attribute . ' is invalid.');
        }
    }
}
