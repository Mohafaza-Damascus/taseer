<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/auth/login.css')
</head>

<body>

    <div class="auth-card">
        <div class="auth-logo-panel">
            <img src="{{ Vite::asset('resources/images/damascus.png') }}" class="header-logo">
        </div>

        <div class="auth-form-panel">
            <div class="auth-head">
                <h1>تسجيل دخول</h1>
            </div>

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf

                <div class="field">
                    <div class="input-group">
                        <img src="{{ Vite::asset('resources/images/user.svg') }}" class="input-icon">
                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                            maxlength="255" placeholder="اسم المستخدم" autofocus>
                    </div>
                    @error('username')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="field">
                    <div class="input-group">
                        <img src="{{ Vite::asset('resources/images/locker.svg') }}" class="input-icon">
                        <input type="password" name="password" id="password" placeholder="كلمة المرور" maxlength="255">
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                            <img src="{{ Vite::asset('resources/images/eye-off.svg') }}" class="eye-icon"
                                alt="إظهار">
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                    @error('credentials')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    تسجيل الدخول
                </button>
            </form>
        </div>
    </div>

</body>
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const img = btn.querySelector('.eye-icon');

        if (input.type === 'password') {
            input.type = 'text';
            img.src = "{{ Vite::asset('resources/images/eye.svg') }}";
            img.alt = 'إخفاء';
        } else {
            input.type = 'password';
            img.src = "{{ Vite::asset('resources/images/eye-off.svg') }}";
            img.alt = 'إظهار';
        }
    }
</script>

</html>
