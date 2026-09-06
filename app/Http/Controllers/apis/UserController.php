<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get all users.
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::query()
            ->with('roles.permissions')
            ->latest()
            ->paginate(
                $request->integer('per_page', 15)
            );

        return ApiResponse::success(
            'تم جلب المستخدمين بنجاح.',
            [
                'users' => UserResource::collection(
                    $users->items()
                ),

                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                ],
            ]
        );
    }


    /**
     * Create employee.
     */
    public function store(
        CreateUserRequest $request
    ): JsonResponse {
        $data = $request->validated();

        $employeeRole = Role::where(
            'slug',
            'employee'
        )->first();

        if (!$employeeRole) {
            return ApiResponse::error(
                'دور الموظف غير موجود.',
                null,
                500
            );
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

        $user->load('roles.permissions');

        return ApiResponse::success(
            'تم إنشاء الموظف بنجاح.',
            [
                'user' => new UserResource($user),
            ],
            201
        );
    }


    /**
     * Get one user.
     */
    public function show(User $user): JsonResponse
    {
        $user->load('roles.permissions');

        return ApiResponse::success(
            'تم جلب بيانات المستخدم بنجاح.',
            [
                'user' => new UserResource($user),
            ]
        );
    }


    /**
     * Update employee.
     */
    public function update(
        UpdateUserRequest $request,
        User $user
    ): JsonResponse {
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

        $user->update($updateData);

        $user->load('roles.permissions');

        return ApiResponse::success(
            'تم تعديل المستخدم بنجاح.',
            [
                'user' => new UserResource($user),
            ]
        );
    }


    /**
     * Delete user.
     */
    public function destroy(User $user): JsonResponse
    {
        if ($user->id === auth()->id()) {
            return ApiResponse::error(
                'لا يمكنك حذف حسابك الحالي.',
                null,
                422
            );
        }

        $user->roles()->detach();

        $user->delete();

        return ApiResponse::success(
            'تم حذف المستخدم بنجاح.'
        );
    }
}