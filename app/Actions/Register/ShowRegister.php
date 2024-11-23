<?php

declare(strict_types = 1);

namespace App\Actions\Register;

use App\Models\{Register};
use App\Rules\StoreRule;
use App\Trait\StoreActionTrait;
use Illuminate\Support\Facades\Validator;

class ShowRegister
{
    use StoreActionTrait;

    protected ?Register $register;

    public function handle(?string $code): Register
    {
        Validator::make(['register' => $code], [
            'register' => ['required', new StoreRule('registers', $this->store->id, 'code')],
        ])->validate();

        $this->register = Register::whereCode($code)->first();

        $this->authorizeForUser($this->user, 'show', [$this->register, $this->store]);

        return $this->register;
    }
}
