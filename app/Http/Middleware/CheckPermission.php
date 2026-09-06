<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {
        $user = $request->user();

        if (!$user) {
            return ApiResponse::error(
                'يجب تسجيل الدخول أولاً.',
                null,
                401
            );
        }

        if (!$user->hasPermission($permission)) {
            return ApiResponse::error(
                'ليس لديك صلاحية لتنفيذ هذه العملية.',
                null,
                403
            );
        }

        return $next($request);
    }
}