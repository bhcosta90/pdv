<?php

declare(strict_types = 1);

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use App\Interfaces\UserInterface;
use App\Models\{Store, User};
use Illuminate\Database\Eloquent\Model;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\LazilyRefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function mockUserInterface(?Store $store = null, ?User $user = null): void
{
    \Pest\Laravel\mock(UserInterface::class, function ($mock) use ($user, $store) {
        $mock->shouldReceive('user')->once()->andReturn($user ?: User::factory()->make());
        $mock->shouldReceive('store')->once()->andReturn($store ?: Store::factory()->create());
    });
}

function mockAuthorizationUser(User &$user, ...$params): void
{
    $ability = array_shift($params);

    $user = Mockery::mock($user)->makePartial();
    $user->shouldReceive('can')
        ->withArgs(function (...$paramsFunction) use ($ability, $params) {
            $abilityCan = array_shift($paramsFunction);

            foreach ($params as $key => $value) {
                if ($value instanceof Model) {
                    if (!$value->is($params[$key])) {
                        return false;
                    }

                    continue;
                }

                if ($value !== $paramsFunction[$key]) {
                    return false;
                }
            }

            return $abilityCan === $ability;
        })
        ->once()
        ->andReturnTrue();
}
