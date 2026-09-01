<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return ApiResponse::error(
                'اسم المستخدم أو كلمة المرور غير صحيحة.',
                null,
                401
            );
        }

        $request->session()->regenerate();

        $user = Auth::user();

        $user->load([
            'roles.permissions',
        ]);

        return ApiResponse::success(
            'تم تسجيل الدخول بنجاح.',
            [
                'user' => new UserResource($user),
            ]
        );
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return ApiResponse::success(
            'تم تسجيل الخروج بنجاح.'
        );
    }

    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();

        $user->load([
            'roles.permissions',
        ]);

        return ApiResponse::success(
            'تم جلب بيانات المستخدم بنجاح.',
            [
                'user' => new UserResource($user),
            ]
        );
    }
}