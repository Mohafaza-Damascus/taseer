<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display users.
     */
    public function index(Request $request): View
    {
        $users = User::query()
            ->with('roles.permissions')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show create user page.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store employee.
     */
    public function store(
        CreateUserRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $employeeRole = Role::where(
            'slug',
            'employee'
        )->first();

        if (!$employeeRole) {
            return back()
                ->withErrors([
                    'error' => 'دور الموظف غير موجود.',
                ])
                ->withInput();
        }

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'] ?? null,
            'password' => $data['password'],
        ]);

        $user->roles()->sync([
            $employeeRole->id,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'تم إنشاء الموظف بنجاح.');
    }

    /**
     * Show user.
     */
    public function show(User $user): View
    {
        $user->load('roles.permissions');

        return view(
            'users.show',
            compact('user')
        );
    }

    /**
     * Show edit page.
     */
    public function edit(User $user): View
    {
        return view(
            'users.edit',
            compact('user')
        );
    }

    /**
     * Update employee.
     */
    public function update(
        UpdateUserRequest $request,
        User $user
    ): RedirectResponse {
        $data = $request->validated();

        $updateData = [];

        if (array_key_exists('name', $data)) {
            $updateData['name'] = $data['name'];
        }

        if (array_key_exists('username', $data)) {
            $updateData['username'] = $data['username'];
        }

        if (array_key_exists('email', $data)) {
            $updateData['email'] = $data['email'];
        }

        if (
            array_key_exists('password', $data)
            && $data['password'] !== null
        ) {
            $updateData['password'] = $data['password'];
        }

        if (!empty($updateData)) {
            $user->update($updateData);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'تم تعديل المستخدم بنجاح.');
    }

    /**
     * Delete user.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'error' => 'لا يمكنك حذف حسابك الحالي.',
            ]);
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'تم حذف المستخدم بنجاح.');
    }
}