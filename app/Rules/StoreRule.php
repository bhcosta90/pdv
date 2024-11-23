<?php

declare(strict_types = 1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;

class StoreRule implements ValidationRule
{
    public function __construct(protected Model $model, protected int $store, protected $column = 'id')
    {
        //
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = $this->model->query()
            ->where($this->column, $value)
            ->where('store_id', $this->store)
            ->exists();

        if (!$exists) {
            $fail('The selected ' . $attribute . ' is invalid.');
        }
    }
}
