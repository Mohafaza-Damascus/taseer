<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأدوار</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/admin/users/index.css')
</head>
<body>
    <div class="container">
        <section class="header-card">
            <h1>الأدوار</h1>
            <a href="" class="btn-go-back">رجوع</a>
        </section>

            <div class="no-results">
                <p>لا يوجد أدوار</p>
            </div>
            <div class="cards-grid">
                <div class="card">
                    <span class="card-title">{{ "اسم الرول" }}</span>
                    <span class="card-subtitle">
                        slug
                    </span>
                    <div class="card-footer">
                        <a href="" class="btn-details">
                            عرض التفاصيل
                        </a>
                    </div>
                </div>

                <a href="" class="add-card" title="إضافة رول جديد">
                    <span class="add-card-icon">+</span>
                </a>
            </div>
    </div>
</body>
</html>
