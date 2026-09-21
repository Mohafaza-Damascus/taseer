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
    | Users 
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
    | Roles 
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
    | Contractors
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/contractors',
        [BladeContractorController::class, 'index']
    )
        ->middleware('permission:contractors.view')
        ->name('contractors.index');

    Route::get(
        '/contractors/create',
        [BladeContractorController::class, 'create']
    )
        ->middleware('permission:contractors.create')
        ->name('contractors.create');

    Route::post(
        '/contractors',
        [BladeContractorController::class, 'store']
    )
        ->middleware('permission:contractors.create')
        ->name('contractors.store');

    Route::get(
        '/contractors/{contractor}',
        [BladeContractorController::class, 'show']
    )
        ->middleware('permission:contractors.view')
        ->name('contractors.show');

    Route::get(
        '/contractors/{contractor}/edit',
        [BladeContractorController::class, 'edit']
    )
        ->middleware('permission:contractors.update')
        ->name('contractors.edit');

    Route::put(
        '/contractors/{contractor}',
        [BladeContractorController::class, 'update']
    )
        ->middleware('permission:contractors.update')
        ->name('contractors.update');

    Route::patch(
        '/contractors/{contractor}',
        [BladeContractorController::class, 'update']
    )
        ->middleware('permission:contractors.update')
        ->name('contractors.update.patch');

    Route::delete(
        '/contractors/{contractor}',
        [BladeContractorController::class, 'destroy']
    )
        ->middleware('permission:contractors.delete')
        ->name('contractors.destroy');

    /*
    |--------------------------------------------------------------------------
    | Incoming Entities
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/incoming_entities',
        [BladeIncomingEntityController::class, 'index']
    )
        ->middleware('permission:incoming_entities.view')
        ->name('incoming_entities.index');

    Route::get(
        '/incoming_entities/create',
        [BladeIncomingEntityController::class, 'create']
    )
        ->middleware('permission:incoming_entities.create')
        ->name('incoming_entities.create');

    Route::post(
        '/incoming_entities',
        [BladeIncomingEntityController::class, 'store']
    )
        ->middleware('permission:incoming_entities.create')
        ->name('incoming_entities.store');

    Route::get(
        '/incoming_entities/{incoming_entity}',
        [BladeIncomingEntityController::class, 'show']
    )
        ->middleware('permission:incoming_entities.view')
        ->name('incoming_entities.show');

    Route::get(
        '/incoming_entities/{incoming_entity}/edit',
        [BladeIncomingEntityController::class, 'edit']
    )
        ->middleware('permission:incoming_entities.update')
        ->name('incoming_entities.edit');

    Route::put(
        '/incoming_entities/{incoming_entity}',
        [BladeIncomingEntityController::class, 'update']
    )
        ->middleware('permission:incoming_entities.update')
        ->name('incoming_entities.update');

    Route::patch(
        '/incoming_entities/{incoming_entity}',
        [BladeIncomingEntityController::class, 'update']
    )
        ->middleware('permission:incoming_entities.update')
        ->name('incoming_entities.update.patch');

    Route::delete(
        '/incoming_entities/{incoming_entity}',
        [BladeIncomingEntityController::class, 'destroy']
    )
        ->middleware('permission:incoming_entities.delete')
        ->name('incoming_entities.destroy');
});

