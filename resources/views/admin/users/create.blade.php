<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إنشاء مستخدم</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/users/create.css')
</head>

<body>

    <div class="container">

        <section class="header-card">
            <h1>إنشاء المستخدم</h1>

            <a href="{{ route('users.index') }}" class="btn-go-back">
                رجوع
            </a>
        </section>


        <form action="{{ route('users.store') }}" method="POST" class="form-card">

            @csrf


            <div class="form-group">

                <label for="username">
                    اسم المستخدم
                </label>

                <input type="text" id="username" name="username" value="{{ old('username') }}" required>

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

                <input type="password" id="password" name="password" autocomplete="new-password" required>

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
                    autocomplete="new-password" required>

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