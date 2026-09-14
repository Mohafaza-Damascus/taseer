<?php

use App\Http\Controllers\Blade\AuthController as BladeAuthController;
use App\Http\Controllers\Blade\ContractorController as BladeContractorController;
use App\Http\Controllers\Blade\DashboardController;
use App\Http\Controllers\Blade\ProjectController as BladeProjectController;
use App\Http\Controllers\Blade\UserController as BladeUserController;
use App\Http\Controllers\Blade\RoleController as BladeRoleController;

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

Route::get('/admin/users/create', function () {
    return view('admin.users.create');
});


    Route::resource(
        'roles',
        BladeRoleController::class
    );




Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [DashboardController::class, 'profile']
    )->name('profile');

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

