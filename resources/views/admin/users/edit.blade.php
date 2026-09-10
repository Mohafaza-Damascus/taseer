<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>username</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/admin/users/edit.css')
</head>
<body>
    <div class="container">
        <section class="header-card">
            <h1>تعديل المستخدم</h1>
            <a href="" class="btn-go-back">رجوع</a>
        </section>

        <form action="" method="POST" class="form-card">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="username">اسم المستخدم</label>
                <input type="text" id="username" name="username"
                       value="username" required>
                <span class="form-error"></span>
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" id="password" name="password"
                       placeholder="••••••••" autocomplete="new-password">

                <span class="form-error"></span>
            </div>

            <div class="form-group">
                <label>الدور</label>

                <div class="radio-list">
                    <label class="radio-item">
                        <input type="radio"
                                name="role_id"
                                value="1">
                        <span class="radio-text">
                            <span class="radio-name">اسم الرول</span>
                        </span>
                    </label>
                    <label class="radio-item">
                        <input type="radio"
                                name="role_id"
                                value="1">
                        <span class="radio-text">
                            <span class="radio-name">اسم الرول</span>
                        </span>
                    </label>
                    <label class="radio-item">
                        <input type="radio"
                                name="role_id"
                                value="1">
                        <span class="radio-text">
                            <span class="radio-name">اسم الرول</span>
                        </span>
                    </label>
                    <label class="radio-item">
                        <input type="radio"
                                name="role_id"
                                value="1">
                        <span class="radio-text">
                            <span class="radio-name">اسم الرول</span>
                        </span>
                    </label>
                    <label class="radio-item">
                        <input type="radio"
                                name="role_id"
                                value="1">
                        <span class="radio-text">
                            <span class="radio-name">اسم الرول</span>
                        </span>
                    </label>

                </div>
                <span class="form-error"></span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">حفظ التعديلات</button>
                <a href="" class="btn-cancel">إلغاء</a>
            </div>
        </form>
    </div>
</body>
</html>
