<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kinan</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/admin/users/show.css')
</head>
<body>
    <div class="container">
        <section class="header-card">
            <h1>تفاصيل المستخدم</h1>
            <a href="" class="btn-go-back">رجوع</a>
        </section>

        <div class="form-card">
            <div class="info-list">
                <div class="info-row">
                    <span class="info-label">اسم المستخدم</span>
                    <span class="info-value">kinan</span>
                </div>
                <div class="info-row">
                    <span class="info-label">تاريخ الإنشاء</span>
                    <span class="info-value">123</span>
                </div>
                <div class="info-row">
                    <span class="info-label">الدور</span>
                    <span class="info-value">مدير</span>
                </div>
            </div>

            <div>
                <span class="section-title">الصلاحيات</span>
                <div class="chip-list">
                    <span class="chip">حذف</span>
                    <span class="chip">كتابة</span>
                    <span class="chip">قراءة</span>
                    <span class="chip">لا يوجد صلاحيات</span>
                </div>
            </div>

            <div class="form-actions">
                <a href="" class="btn-edit">تعديل</a>
                <form action=""
                      method="POST"
                      onsubmit="return confirm('هل أنت متأكد من حذف المستخدم؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">حذف</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
