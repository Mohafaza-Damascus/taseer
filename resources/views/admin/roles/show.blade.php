<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الدور</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/admin/roles/show.css')
</head>
<body>
    <div class="container">
        <section class="header-card">
            <h1>تفاصيل الدور</h1>
            <a href="" class="btn-go-back">رجوع</a>
        </section>

        <div class="form-card">
            <div class="info-list">
                <div class="info-row">
                    <span class="info-label">الاسم</span>
                    <span class="info-value">اسم الدور</span>
                </div>
                <div class="info-row">
                    <span class="info-label">slug</span>
                    <span class="info-value">slug</span>
                </div>
            </div>

            <div>
                <span class="section-title">الصلاحيات (عدد الصلاحيات)</span>
                <div class="chip-list">
                        <span class="chip">صلاحية 1</span>
                        <span class="chip">صلاحية 2</span>
                        <span class="chip">صلاحية 3</span>
                        <span class="chip">صلاحية 4</span>
                        <span class="chip">صلاحية 5</span>
                        <span class="chip">لا يوجد صلاحيات</span>
                </div>
            </div>

            <div>
                <span class="section-title">المستخدمون بهذا الدور (عدد المستخدمين)</span>
                <div class="chip-list">
                    <span class="chip">كنان عايد</span>
                    <span class="chip">سامي زكريا</span>
                    <span class="chip">محمود الأشقر</span>
                    <span class="chip">لا يوجد مستخدمون</span>
                </div>
            </div>

            <div class="form-actions">
                <a href="" class="btn-edit">تعديل</a>

                <form action=""
                      method="POST"
                      onsubmit="return confirm('هل أنت متأكد من حذف الدور؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">حذف</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
