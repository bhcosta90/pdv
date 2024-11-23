<?php

declare(strict_types = 1);

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Lorisleiva\Actions\Concerns\{AsAction, WithAttributes};

arch('dump')
    ->expect('App')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);

arch('actions')
    ->expect('App\Actions')
    ->toBeClasses()
    ->toExtendNothing()
    ->toHaveLineCountLessThan(100)
    ->toUseTraits([AsAction::class, WithAttributes::class])
    ->toHaveMethods(['authorize', 'rules', 'handle'])
    ->not->toHaveProtectedMethodsBesides(['rules', 'authorize']);

arch('model')
    ->expect('App\Models')
    ->toBeClasses()
    ->toUseTraits([SoftDeletes::class])
    ->toExtend(Model::class);

arch('http')
    ->expect('App\Http')
    ->toOnlyBeUsedIn('App\Http');

arch('php')->preset()->php();

arch('md5')->preset()->security()->ignoring('md5');
