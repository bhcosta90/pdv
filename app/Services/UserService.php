<?php

declare(strict_types = 1);

namespace App\Services;

use App\Interfaces\UserInterface;
use App\Models\{Store, User};

class UserService implements UserInterface
{
    protected User $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function store(): Store
    {
        return Store::first();
    }

    public function user(): User
    {
        return $this->user;
    }
}