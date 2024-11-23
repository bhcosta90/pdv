<?php

declare(strict_types = 1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValueMaxRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_numeric($value) && $value <= 18446744073709551615) {
            $fail('The :attribute must be less than or equal to 18,4 quadrillions.');
        }
    }
}
