<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المشاريع</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/admin/users/index.css')
</head>
<body>
    <div class="container">
        <section class="header-card">
            <h1>المستخدمين</h1>
            <button type="button" class="btn-go-back" id="resetFilters">
                رجوع
            </button>
        </section>

        <div class="users-grid">
            <div class="users-container">
                <div class="user-card">
                    <span class="user-name">كنان عايد</span>
                    <span class="user-role">موظف</span>
                    <div class="card-footer">
                        <button type="button" class="btn-details">
                            عرض التفاصيل
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" class="add-card" title="إضافة مستخدم جديد">
                <span class="add-card-icon">+</span>
            </button>
        </div>

        <div class="no-results" id="noResults">
            <p>لا يوجد مستخدمين</p>
        </div>
    </div>
</body>
</html>
