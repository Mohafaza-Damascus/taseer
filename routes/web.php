<?php

use App\Http\Controllers\Blade\AuthController as BladeAuthController;
use App\Http\Controllers\Blade\ContractorController as BladeContractorController;
use App\Http\Controllers\Blade\DashboardController;
use App\Http\Controllers\Blade\ProjectController as BladeProjectController;
use App\Http\Controllers\Blade\UserController as BladeUserController;
use App\Http\Controllers\Blade\RoleController as BladeRoleController;
use App\Http\Controllers\Blade\IncomingEntityController as BladeIncomingEntityController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('dashboard');
});





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
    | Roles - Blade
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:role.manage')->group(function () {

        Route::resource(
            'roles',
            BladeRoleController::class
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Projects
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/projects',
        [BladeProjectController::class, 'index']
    )
        ->middleware('permission:projects.view')
        ->name('projects.index');

    Route::get(
        '/projects/create',
        [BladeProjectController::class, 'create']
    )
        ->middleware('permission:projects.create')
        ->name('projects.create');

    Route::post(
        '/projects',
        [BladeProjectController::class, 'store']
    )
        ->middleware('permission:projects.create')
        ->name('projects.store');

    Route::get(
        '/projects/{project}',
        [BladeProjectController::class, 'show']
    )
        ->middleware('permission:projects.view')
        ->name('projects.show');

    Route::get(
        '/projects/{project}/edit',
        [BladeProjectController::class, 'edit']
    )
        ->middleware('permission:projects.update')
        ->name('projects.edit');

    Route::put(
        '/projects/{project}',
        [BladeProjectController::class, 'update']
    )
        ->middleware('permission:projects.update')
        ->name('projects.update');

    Route::patch(
        '/projects/{project}',
        [BladeProjectController::class, 'update']
    )
        ->middleware('permission:projects.update')
        ->name('projects.update.patch');

    Route::delete(
        '/projects/{project}',
        [BladeProjectController::class, 'destroy']
    )
        ->middleware('permission:projects.delete')
        ->name('projects.destroy');

    /*
    |--------------------------------------------------------------------------
    | Contractors - Blade
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'contractors',
        BladeContractorController::class
    );

    /*
    |--------------------------------------------------------------------------
    | IncomingEntityController - Blade
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'incoming_entities',
        BladeIncomingEntityController::class
    );
});

