<?php

declare(strict_types = 1);

namespace App\Trait;

use App\Interfaces\UserInterface;
use App\Models\{Store, User};

trait StoreActionTrait
{
    protected Store $store;

    protected User $user;

    public function __construct(UserInterface $userInterface)
    {
        $this->store = $userInterface->store();
        $this->user  = $userInterface->user();
    }
}
