<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الدور - {{ $role->name }}</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/admin/roles/edit.css')
</head>
<body>
    <div class="container">
        <section class="header-card">
            <h1>تعديل الدور</h1>
            <a href="" class="btn-go-back">رجوع</a>
        </section>

        <form action="" method="POST" class="form-card">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">الاسم</label>
                <input type="text" id="name" name="name"
                       value="ss" required>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="slug">المُعرّف</label>
                <input type="text" id="slug" name="slug"
                       value="ssss" required>
                <span class="form-hint">مثال: admin, editor, viewer</span>
                @error('slug')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>الصلاحيات</label>
                <div class="checkbox-list">
                    @foreach($permissions as $permission)
                        <label class="checkbox-item">
                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $permission->id }}"
                                   @checked(in_array($permission->id, old('permissions', $role->permissions->pluck('id')->all())))>
                            <span>{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">حفظ التعديلات</button>
                <a href="" class="btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</body>
</html>
