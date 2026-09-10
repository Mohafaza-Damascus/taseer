<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'username' => 'اسم المستخدم أو كلمة المرور غير صحيحة.',
                ])
                ->withInput($request->only('username'));
        }

        $request->session()->regenerate();

        return redirect()
            ->intended('/dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}
