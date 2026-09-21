<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->with('roles')
            ->latest()
            ->paginate(15);

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    public function create(): View
    {
        $roles = Role::query()
            ->orderBy('name')
            ->get();

        return view(
            'admin.users.create',
            compact('roles')
        );
    }

    public function store(
        CreateUserRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $user = User::create([
            'username' => $data['username'],
            'password' => $data['password'],
        ]);

        $user->roles()->sync([
            $data['role_id'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح.');
    }

    public function show(User $user): View
    {
        $user->load([
            'roles.permissions',
        ]);

        return view(
            'admin.users.show',
            compact('user')
        );
    }

    public function edit(User $user): View
    {
        $user->load('roles');

        $roles = Role::query()
            ->orderBy('name')
            ->get();

        return view(
            'admin.users.edit',
            compact(
                'user',
                'roles'
            )
        );
    }

    public function update(
        UpdateUserRequest $request,
        User $user
    ): RedirectResponse {
        $data = $request->validated();

        $updateData = [
            'username' => $data['username'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = $data['password'];
        }

        $user->update($updateData);

        $user->roles()->sync([
            $data['role_id'],
        ]);

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'تم تعديل المستخدم بنجاح.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->roles()->detach();

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'تم حذف المستخدم بنجاح.');
    }
}