<?php

declare(strict_types = 1);

use App\Actions\Register\OpenRegister;
use App\Exceptions\RegisterAttemptException;
use App\Models\Enums\{RegisterHistoryAction, RegisterHistoryType};
use App\Models\Register;

beforeEach(function () {
    $user = mockUserInterface();

    $this->register = Register::factory()->recycle($user->store)->create(['balance' => 20]);
    $this->action   = app(OpenRegister::class);
    mockAuthorizeUser($user->user, 'open', $this->register, $user->store);
});

it('opens register with zero balance', function () {
    $this->action->handle((string) $this->register->code, 20.0);

    expect($this->register->refresh())
        ->balance->toBe(20.0);
});

it('throws exception and updates balance with credit history when opening register with non-zero balance', function () {
    $value = 98.24;

    expect(fn () => $this->action->handle((string) $this->register->code, $value))->toThrow(RegisterAttemptException::class);

    $this->action->handle((string) $this->register->code, $value);

    expect($this->register->refresh())
        ->balance->toBe($value)
        ->histories->toHaveCount(1)
        ->and($this->register->histories->get(0)->toArray())->toMatchArray([
            'action' => RegisterHistoryAction::Open->value,
            'type'   => RegisterHistoryType::Credit->value,
            'value'  => 78.24,
        ]);

});

it('throws exception and updates balance with debit history when opening register with non-zero balance', function () {
    $this->register->balance = 200;
    $this->register->save();

    $value = 98.24;

    expect(fn () => $this->action->handle((string) $this->register->code, $value))->toThrow(RegisterAttemptException::class);

    $this->action->handle((string) $this->register->code, $value);

    expect($this->register->refresh())
        ->balance->toBe($value)
        ->histories->toHaveCount(1)
        ->and($this->register->histories->get(0)->toArray())->toMatchArray([
            'action' => RegisterHistoryAction::Open->value,
            'type'   => RegisterHistoryType::Debit->value,
            'value'  => 101.76,
        ]);

});
