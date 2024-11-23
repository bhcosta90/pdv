<?php

declare(strict_types = 1);

use App\Actions\Register\ShowRegister;
use App\Models\{Register, Store, User};
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    $this->store = Store::factory()->create();
    $this->user  = User::factory()->make();
});

it('throws an AuthorizationException when the user is not authorized to define a register', function () {
    mockUserInterface();

    $register = Register::factory()->create();

    /** @var ShowRegister $action */
    $action = app(ShowRegister::class);

    $action->handle((string) $register->code);
})->throws(ValidationException::class);

it('returns the correct register when the user is authorized', function () {
    $register = Register::factory()->recycle($this->store)->create();

    mockAuthorizeUser($this->user, 'show', $register, $this->store);
    mockUserInterface($this->store, $this->user);

    /** @var ShowRegister $action */
    $action = app(ShowRegister::class);

    $responseRegister = $action->handle((string) $register->code);

    expect($responseRegister->id)->toBe($register->id);
});
