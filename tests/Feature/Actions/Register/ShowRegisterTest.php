<?php

declare(strict_types = 1);

use App\Actions\Register\ShowRegister;
use App\Models\{Register, Store, User};
use Illuminate\Auth\Access\AuthorizationException;

beforeEach(function () {
    $this->store = Store::factory()->create();
    $this->user  = User::factory()->make();
});

it('throws an AuthorizationException when the user is not authorized to define a register', function () {
    mockUserInterface();

    $register = Register::factory()->create();

    /** @var ShowRegister $action */
    $action = app(ShowRegister::class);

    $action->handle($register->code);
})->throws(AuthorizationException::class);

it('returns the correct register when the user is authorized', function () {
    $register = Register::factory()->recycle($this->store)->create();

    mockAuthorizationUser($this->user, 'show', $register, $this->store);
    mockUserInterface($this->store, $this->user);

    /** @var ShowRegister $action */
    $action = app(ShowRegister::class);

    $responseRegister = $action->handle($register->code);

    expect($responseRegister->id)->toBe($register->id);
});