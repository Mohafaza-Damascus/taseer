<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الدور</title>
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
                <span class="form-error"></span>
            </div>

            <div class="form-group">
                <label for="slug">slug</label>
                <input type="text" id="slug" name="slug"
                       value="ssss" required>
                @error('slug')
                    <span class="form-error"></span>
                @enderror
            </div>

            <div class="form-group">
                <label>الصلاحيات</label>
                <div class="checkbox-list">
                    <label class="checkbox-item">
                        <input type="checkbox"
                                name="permissions[]"
                                value="صلاحية 1">
                        <span class="checkbox-text">صلاحية 1</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox"
                                name="permissions[]"
                                value="صلاحية 2">
                        <span class="checkbox-text">صلاحية 2</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox"
                                name="permissions[]"
                                value="صلاحية 3">
                        <span class="checkbox-text">صلاحية 3</span>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">حفظ</button>
                <a href="" class="btn-cancel">إلغاء</a>
            </div>
        </form>
    </div>
</body>
</html>
