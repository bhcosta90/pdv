<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\{Enums\Can, Register, Store, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class RegisterPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Register $register, Store $store): bool
    {
        return $user->can(Can::Register) && $register->store_id === $store->id;
    }
}
