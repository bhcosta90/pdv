<?php

declare(strict_types = 1);

namespace App\Trait;

use App\Interfaces\UserInterface;
use App\Models\{Store, User};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait StoreActionTrait
{
    use AuthorizesRequests;

    protected Store $store;

    protected User $user;

    public function __construct(UserInterface $userInterface)
    {
        $this->store = $userInterface->store();
        $this->user  = $userInterface->user();
    }
}
