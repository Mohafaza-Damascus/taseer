<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $user->username }}</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/users/edit.css')
</head>

<body>

    <div class="container">

        <section class="header-card">

            <h1>
                تعديل المستخدم
            </h1>

            <a href="{{ route('users.show', $user) }}" class="btn-go-back">
                رجوع
            </a>

        </section>


        <form action="{{ route('users.update', $user) }}" method="POST" class="form-card" novalidate>

            @csrf
            @method('PUT')


            <div class="form-group">

                <label for="username">
                    اسم المستخدم
                </label>

                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}"
                    @class(['input-error' => $errors->has('username')])>

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

                <input type="password" id="password" name="password"
                    placeholder="اتركها فارغة للإبقاء على كلمة المرور الحالية" autocomplete="new-password" @class(['input-error' => $errors->has('password')])>

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
                    autocomplete="new-password">

            </div>


            <div class="form-group">

                <label>
                    الدور
                </label>

                <div class="radio-list">

                    @foreach ($roles as $role)

                        <label class="radio-item">

                            <input type="radio" name="role_id" value="{{ $role->id }}" @checked(
                                old(
                                    'role_id',
                                    $user->roles->first()?->id
                                ) == $role->id
                            )>

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
                    حفظ التعديلات
                </button>

                <a href="{{ route('users.show', $user) }}" class="btn-cancel">
                    إلغاء
                </a>

            </div>

        </form>

    </div>

</body>

</html>
