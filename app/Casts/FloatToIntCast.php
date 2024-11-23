<?php

declare(strict_types = 1);

namespace App\Casts;

use App\Facades\BcMathNumberFacade;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class FloatToIntCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (isset($value)) {
            return BcMathNumberFacade::make($value)->div('1000')->toFloat();
        }

        return null;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (isset($value)) {
            return (int) BcMathNumberFacade::make($value)->mul('1000')->__toString();
        }

        return null;
    }
}
