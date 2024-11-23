<?php

declare(strict_types = 1);

use App\Livewire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', Livewire\Welcome::class)->name('dashboard');

    Route::middleware('register.defined')->group(function () {
        Route::middleware('register.open')->group(function () {
            Route::as('sale.')->prefix('sale')->group(function () {
                Route::get('create', fn () => 'oi')->name('create');
            });
        });
    });

    Route::as('register.')->prefix('register')->group(function () {
        Route::get('define', Livewire\Register\Defined::class)->name('define');
    });
});

Route::get('login', function (Request $request) {
    $request->headers->set('Accept', 'application/json');
    $request->headers->set('Content-Type', 'application/json');

    $request->validate([
        'email' => ['required', 'email', 'exists:users,email'],
    ]);

    $user = App\Models\User::whereEmail($request->email)->firstOrFail();
    auth()->login($user);

    return redirect()->route('dashboard');

})->name('login');
