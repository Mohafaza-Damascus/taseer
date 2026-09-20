<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\IncomingEntity;
use App\Models\Contractor;

class DashboardController extends Controller
{
    public function index(): View
    {
        $usersCount = User::count();
        $rolesCount = Role::count();
        $projectsCount = Project::count();
        $incomingEntitiesCount = IncomingEntity::count();
        $contractorsCount = Contractor::count();
        return view('dashboard.index', compact(
            'usersCount',
            'rolesCount',
            'projectsCount',
            'incomingEntitiesCount',
            'contractorsCount'
        ));
    }

    public function profile(): View
    {
        $user = auth()->user();

        $user->load([
            'roles.permissions',
        ]);

        return view(
            'auth.profile',
            compact('user')
        );
    }
}
