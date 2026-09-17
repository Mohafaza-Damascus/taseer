<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إنشاء مستخدم</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/users/create.css')

    <style>
        .success-message {
            margin-bottom: 20px;
            padding: 12px 16px;
            border-radius: 10px;
            background-color: #e8f5e9;
            color: #1b5e20;
            border: 1px solid #a5d6a7;
            font-family: var(--font-thmanyahseriftext-medium);
        }

        .form-error {
            display: block;
            margin-top: 6px;
            color: #c62828;
            font-size: 0.85rem;
            font-family: var(--font-thmanyahseriftext-medium);
        }

        .input-error {
            border-color: #c62828 !important;
        }
    </style>
</head>

<body>

    <div class="container">

        <section class="header-card">

            <h1>
                إنشاء المستخدم
            </h1>

            <a href="{{ route('users.index') }}" class="btn-go-back">
                رجوع
            </a>

        </section>


        @if (session('success'))

            <div class="success-message">
                {{ session('success') }}
            </div>

        @endif


        <form action="{{ route('users.store') }}" method="POST" class="form-card" novalidate>

            @csrf


            <div class="form-group">

                <label for="username">
                    اسم المستخدم
                </label>

                <input type="text" id="username" name="username" value="{{ old('username') }}"
                    class="@error('username') input-error @enderror" required>

                @error('username')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <div class="form-group">

                <label for="password">
                    كلمة المرور
                </label>

                <input type="password" id="password" name="password" autocomplete="new-password"
                    class="@error('password') input-error @enderror" required>

                @error('password')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <div class="form-group">

                <label for="password_confirmation">
                    تأكيد كلمة المرور
                </label>

                <input type="password" id="password_confirmation" name="password_confirmation"
                    autocomplete="new-password" class="@error('password_confirmation') input-error @enderror" required>

                @error('password_confirmation')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <div class="form-group">

                <label>
                    الدور
                </label>

                <div class="radio-list">

                    @foreach ($roles as $role)

                        <label class="radio-item">

                            <input type="radio" name="role_id" value="{{ $role->id }}" @checked(old('role_id') == $role->id)>

                            <span class="radio-text">

                                <span class="radio-name">
                                    {{ $role->name }}
                                </span>

                            </span>

                        </label>

                    @endforeach

                </div>

                @error('role_id')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <div class="form-actions">

                <button type="submit" class="btn-save">
                    حفظ
                </button>

                <a href="{{ route('users.index') }}" class="btn-cancel">
                    إلغاء
                </a>

            </div>

        </form>

    </div>

</body>

</html>