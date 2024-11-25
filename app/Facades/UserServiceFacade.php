<?php

declare(strict_types = 1);

namespace App\Facades;

use App\Models\{Store, User};
use App\Services\UserService;
use Illuminate\Support\Facades\Facade;

/**
 * @see UserService
 * @method static Store|null store()
 * @method static User|null user()
 */
class UserServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return UserService::class;
    }
}
