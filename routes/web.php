<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
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


    // -------------------------------------------
    // Users - Admin Only
    // -------------------------------------------

    Route::middleware('permission:users.manage')->group(
        function () {

            Route::apiResource(
                'users',
                UserController::class
            );

        }
    );
    /*  
    |--------------------------------------------------------------------------
    | Projects
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:projects.view')->group(function () {
        Route::get(
            '/projects',
            [ProjectController::class, 'index']
        );
        Route::get(
            '/projects/{project}',
            [ProjectController::class, 'show']
        );
    });

    Route::middleware('permission:projects.create')->group(function () {
        Route::post(
            '/projects',
            [ProjectController::class, 'store']
        );
    });

    Route::middleware('permission:projects.update')->group(function () {
        Route::put(
            '/projects/{project}',
            [ProjectController::class, 'update']
        );
        Route::patch(
            '/projects/{project}',
            [ProjectController::class, 'update']
        );
    });

    Route::middleware('permission:projects.delete')->group(function () {
        Route::delete(
            '/projects/{project}',
            [ProjectController::class, 'destroy']
        );
    });

});