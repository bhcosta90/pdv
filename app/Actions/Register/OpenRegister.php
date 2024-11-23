<?php

namespace App\Actions\Register;

use App\Models\Register;
use App\Rules\StoreRule;
use App\Trait\StoreActionTrait;

class OpenRegister
{
    use AsAction;
    use StoreActionTrait;

    public function handle(?string $code): Register
    {
        Validator::make(['register' => $code], [
            'register' => ['required', new StoreRule('registers', $this->store->id, 'code')],
        ])->validate();

        $this->register = Register::whereCode($code)->first();

        $this->authorizeForUser($this->user, 'open', [$this->register, $this->store]);

        return $this->register;
    }
}
