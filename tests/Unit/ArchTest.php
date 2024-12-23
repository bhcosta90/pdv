<?php

declare(strict_types = 1);

use App\Trait\StoreActionTrait;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

arch('dump')
    ->expect('App')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);

arch('actions')
    ->expect('App\Actions')
    ->toBeClasses()
    ->toExtendNothing()
    ->toHaveLineCountLessThan(100)
    ->toUseTraits([StoreActionTrait::class])
    ->toHaveMethods(['handle']);

arch('model')
    ->expect('App\Models')
    ->toBeClasses()
    ->ignoring('App\Models\Enums')
    ->toUseTraits([SoftDeletes::class])
    ->ignoring('App\Models\Enums')
    ->toExtend(Model::class)
    ->ignoring('App\Models\Enums');

arch('enums')
    ->expect('App\Models\Enums')
    ->toBeEnums();

arch('models - enums')
    ->expect('App\Models')
    ->enums()
    ->toOnlyBeUsedIn('App\Models');

arch('http')
    ->expect('App\Http')
    ->toOnlyBeUsedIn('App\Http');

arch('php')->preset()->php();

arch('md5')->preset()->security()->ignoring('md5');
