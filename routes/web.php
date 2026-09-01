<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


// =====================================================
// Auth Blade
// =====================================================

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


// =====================================================
// Authenticated Blade
// =====================================================

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('auth.profile');
    })->name('profile');

});


// =====================================================
// APIs
// =====================================================

Route::prefix('api/v1')->group(function () {

    Route::post('/auth/login', [
        AuthController::class,
        'login',
    ]);

    Route::middleware('auth')->group(function () {

        Route::post('/auth/logout', [
            AuthController::class,
            'logout',
        ]);

        Route::get('/auth/profile', [
            AuthController::class,
            'profile',
        ]);

    });

});