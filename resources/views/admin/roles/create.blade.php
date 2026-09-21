<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إنشاء الدور</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/roles/create.css')

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
                إنشاء الدور
            </h1>

            <a href="{{ route('roles.index') }}" class="btn-go-back">
                رجوع
            </a>

        </section>


        @if (session('success'))

            <div class="success-message">
                {{ session('success') }}
            </div>

        @endif


        <form action="{{ route('roles.store') }}" method="POST" class="form-card" novalidate>

            @csrf


            <div class="form-group">

                <label for="name">
                    الاسم
                </label>

                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    @class(['input-error' => $errors->has('name')]) >

                @error('name')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <div class="form-group">

                <label for="slug">
                    slug
                </label>

                <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                    @class(['input-error' => $errors->has('slug')]) >

                @error('slug')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <div class="form-group">

                <label>
                    الصلاحيات
                </label>

                <div class="checkbox-list">

                    @foreach ($permissions as $permission)

                        <label class="checkbox-item">

                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked(
                                in_array(
                                    $permission->id,
                                    old('permissions', [])
                                )
                            )>

                            <span class="checkbox-text">
                                {{ $permission->name }}
                            </span>

                        </label>

                    @endforeach

                </div>

                @error('permissions')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

                @error('permissions.*')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <div class="form-actions">

                <button type="submit" class="btn-save">
                    حفظ
                </button>

                <a href="{{ route('roles.index') }}" class="btn-cancel">
                    إلغاء
                </a>

            </div>

        </form>

    </div>

</body>

</html>
