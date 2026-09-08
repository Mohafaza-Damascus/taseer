<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/auth/login.css')
    @if (isset($vite))
        @foreach ($vite as $file)
            @vite($file)
        @endforeach
    @endif
</head>

<body class="auth-body">

    <div class="auth-wrapper">
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
                            {{-- <img src="{{ Vite::asset('resources/images/user.svg') }}" class="input-icon"> --}}
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <input type="text" name="username" id="username" value="{{ old('username') }}"
                                maxlength="255" placeholder="اسم المستخدم" autofocus>
                        </div>
                        @error('username')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <div class="input-group">
                            {{-- <img src="{{ Vite::asset('resources/images/locker.svg') }}" class="input-icon"> --}}
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input type="password" name="password" id="password" placeholder="كلمة المرور" maxlength="255">
                            <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                                {{-- <img src="{{ Vite::asset('resources/images/eye-off.svg') }}" class="eye-icon"
                                    alt="إظهار"> --}}
                                    <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                    </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    @error('credentials')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="btn-submit">
                        تسجيل الدخول
                    </button>
                </form>
            </div>
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
