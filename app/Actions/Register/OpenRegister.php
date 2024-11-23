<?php

declare(strict_types = 1);

namespace App\Actions\Register;

use App\Actions\Register\Exception\RegisterAttemptException;
use App\Models\Enums\RegisterHistoryAction;
use App\Models\Register;
use App\Rules\StoreRule;
use App\Trait\StoreActionTrait;
use Illuminate\Support\Facades\Validator;

class OpenRegister
{
    use StoreActionTrait;

    public function handle(?string $code, ?float $balance): Register
    {
        Validator::make(['register' => $code, 'balance' => $balance], [
            'register' => ['required', new StoreRule('registers', $this->store->id, 'code')],
            'balance'  => ['required', 'numeric', 'min:0'],
        ])->validate();

        $register = Register::whereCode($code)->first();

        $this->authorizeForUser($this->user, 'open', [$register, $this->store]);

        if ($balance !== $register->balance && $register->closed_attempt === null) {
            $register->closed_attempt = 1;
            $register->save();

            throw new RegisterAttemptException('The balance is different from the last closed balance.');
        }

        $register->registerActivity($balance, RegisterHistoryAction::Open);

        $register->opened_by = $this->user->id;
        $register->closed_by = null;

        $register->opened_at = now();
        $register->closed_at = null;

        $register->opened_attempt = null;
        $register->closed_attempt = null;

        $register->save();

        return $register;
    }
}
