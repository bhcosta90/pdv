<?php

declare(strict_types = 1);

use App\Actions\Register\Exception\RegisterAttemptException;
use App\Actions\Register\CloseRegister;
use App\Models\Enums\{RegisterHistoryAction, RegisterHistoryType};
use App\Models\Register;

beforeEach(function () {
    $user           = mockUserInterface();

    $this->register = Register::factory()->recycle($user->store)->create(['balance' => 20]);
    $this->action = app(CloseRegister::class);
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
            'action' => RegisterHistoryAction::Close->value,
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
            'action' => RegisterHistoryAction::Close->value,
            'type'   => RegisterHistoryType::Debit->value,
            'value'  => 101.76,
        ]);

});
