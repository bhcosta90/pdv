<?php

declare(strict_types = 1);

use App\Livewire\Welcome;
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
    Route::get('/', Welcome::class)->name('dashboard');
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
