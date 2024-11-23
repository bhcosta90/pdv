<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Interfaces\UserInterface;
use App\Models\Enums\Can;
use App\Services\UserService;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Webit\Wrapper\BcMath\BcMathNumber;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UserInterface::class, UserService::class);
    }

    public function boot(): void
    {
        BcMathNumber::setDefaultScale(4);

        foreach (Can::cases() as $can) {
            Gate::define($can, fn (User $user) => true);
        }
    }
}
