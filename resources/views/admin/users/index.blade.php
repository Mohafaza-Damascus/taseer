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

        <div class="projects-grid">
            <div id="projectsContainer" class="projects-container">
                <div class="project-card">
                    <div class="card-header">
                        <span>مشروع اعمار</span>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <label>الجهة :</label>
                            <span>وزارة الاسكان</span>
                        </div>
                        <div class="info-item">
                            <label>المقاول :</label>
                            <span>كنان فتحي عايد</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn-details">
                            عرض التفاصيل
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" class="add-card" id="addProjectBtn" title="إضافة مشروع جديد">
                <span class="add-card-icon">+</span>
            </button>
        </div>

        <div class="no-results" id="noResults">
            <p>لا توجد مشاريع تطابق معايير البحث</p>
        </div>
    </div>
</body>

</html>
