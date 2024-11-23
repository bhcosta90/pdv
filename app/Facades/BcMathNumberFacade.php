<?php

declare(strict_types = 1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Webit\Wrapper\BcMath\BcMathNumber;

/**
 * @see BcMathNumber
 */
class BcMathNumberFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BcMathNumber::class;
    }

    public static function make(mixed $value): BcMathNumber
    {
        return new BcMathNumber($value);
    }
}
