<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::query()
            ->withCount([
                'permissions',
                'users',
            ])
            ->orderBy('name')
            ->paginate(15);

        return view(
            'admin.roles.index',
            compact('roles')
        );
    }

    public function create(): View
    {
        $permissions = Permission::query()
            ->orderBy('name')
            ->get();

        return view(
            'admin.roles.create',
            compact('permissions')
        );
    }

    public function store(
        CreateRoleRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $role = Role::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);

        $role->permissions()->sync(
            $data['permissions'] ?? []
        );

        return redirect()
            ->route('roles.show', $role)
            ->with('success', 'تم إنشاء الدور بنجاح.');
    }

    public function show(Role $role): View
    {
        $role->load([
            'permissions',
            'users',
        ]);

        return view(
            'admin.roles.show',
            compact('role')
        );
    }

    public function edit(Role $role): View
    {
        $role->load('permissions');

        $permissions = Permission::query()
            ->orderBy('name')
            ->get();

        return view(
            'admin.roles.edit',
            compact(
                'role',
                'permissions'
            )
        );
    }

    public function update(
        UpdateRoleRequest $request,
        Role $role
    ): RedirectResponse {
        $data = $request->validated();

        $role->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);

        $role->permissions()->sync(
            $data['permissions'] ?? []
        );

        return redirect()
            ->route('roles.show', $role)
            ->with('success', 'تم تعديل الدور بنجاح.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->permissions()->detach();
        $role->users()->detach();

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'تم حذف الدور بنجاح.');
    }
}