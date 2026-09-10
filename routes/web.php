<?php

use App\Http\Controllers\Apis\AuthController;
use App\Http\Controllers\Apis\ContractorController;
use App\Http\Controllers\Apis\ProjectController;
use App\Http\Controllers\Apis\UserController;

use App\Http\Controllers\Blade\AuthController as BladeAuthController;
use App\Http\Controllers\Blade\ContractorController as BladeContractorController;
use App\Http\Controllers\Blade\ProjectController as BladeProjectController;
use App\Http\Controllers\Blade\UserController as BladeUserController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Blade
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Authentication - Blade
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [
        BladeAuthController::class,
        'login',
    ])->name('login.store');
});

Route::post('/logout', [
    BladeAuthController::class,
    'logout',
])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Blade Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('projects.index');
})->name('dashboard');

Route::get('/show', function () {
    return view('projects.show');
});


Route::get('/admin/users', function () {
    return view('admin.users.index');
});
Route::get('/admin/users/show', function () {
    return view('admin.users.show');
});

Route::get('/admin/users/edit', function () {
    return view('admin.users.edit');
});


Route::get('/admin/roles', function () {
    return view('admin.roles.index');
});
Route::get('/admin/roles/show', function () {
    return view('admin.roles.show');
});

Route::get('/admin/roles/edit', function () {
    return view('admin.roles.edit');
});




Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', function () {
        return view('auth.profile');
    })->name('profile');

    /*
    |--------------------------------------------------------------------------
    | Users - Blade
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:users.manage')->group(function () {

        Route::resource(
            'users',
            BladeUserController::class
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Projects - Blade
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'projects',
        BladeProjectController::class
    );

    /*
    |--------------------------------------------------------------------------
    | Contractors - Blade
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'contractors',
        BladeContractorController::class
    );
});


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes keep using the original API Controllers.
|
*/

Route::prefix('api/v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication API
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Users API - Admin Only
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:users.manage')->group(function () {

        Route::apiResource(
            'users',
            UserController::class
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Projects API
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


    /*
    |--------------------------------------------------------------------------
    | Contractors API
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:contractors.create')->group(function () {

        Route::post(
            '/contractors',
            [ContractorController::class, 'store']
        );

    });

    Route::middleware('permission:contractors.view')->group(function () {

        Route::get(
            '/contractors',
            [ContractorController::class, 'index']
        );

        Route::get(
            '/contractors/{contractor}',
            [ContractorController::class, 'show']
        );

    });

    Route::middleware('permission:contractors.update')->group(function () {

        Route::put(
            '/contractors/{contractor}',
            [ContractorController::class, 'update']
        );

        Route::patch(
            '/contractors/{contractor}',
            [ContractorController::class, 'update']
        );

    });

    Route::middleware('permission:contractors.delete')->group(function () {

        Route::delete(
            '/contractors/{contractor}',
            [ContractorController::class, 'destroy']
        );

    });

});
