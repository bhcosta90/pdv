<?php

declare(strict_types = 1);

use App\Actions\Register\BrowserRegister;
use App\Models\{Register, Store, User};
use Illuminate\Support\Facades\{Cookie};

beforeEach(function () {
    $this->store = Store::factory()->create();
    $this->user  = User::factory()->make();
});

it('returns null when no register cookie is set', function () {
    mockUserInterface();

    Cookie::shouldReceive('get')->with('register')->andReturnNull();
    Cookie::shouldReceive('queue')->with('register')->andReturnNull();

    /** @var BrowserRegister $action */
    $action = app(BrowserRegister::class);

    expect($action->handle())->toBeNull();

});

it('returns null when the register cookie is not set and cannot be queued', function () {
    mockUserInterface();
    $register = Register::factory()->recycle($this->store)->create();

    Cookie::shouldReceive('get')->with('register')->andReturnNull();
    Cookie::shouldReceive('queue')->with('register')->andReturn($register->code);

    /** @var BrowserRegister $action */
    $action = app(BrowserRegister::class);

    $responseRegister = $action->handle();

    expect($action->handle())->toBeNull();
});

it('returns the correct register when the register cookie is set', function () {
    mockUserInterface(store: $this->store);
    $register = Register::factory()->recycle($this->store)->create();

    Cookie::shouldReceive('get')->with('register')->andReturnNull();
    Cookie::shouldReceive('queue')->with('register')->andReturn($register->code);

    /** @var BrowserRegister $action */
    $action = app(BrowserRegister::class);

    $responseRegister = $action->handle();

    expect($responseRegister->id)->toBe($register->id);
});
