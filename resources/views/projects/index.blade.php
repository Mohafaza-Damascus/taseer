<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المشاريع</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/projects/index.css')
</head>
<body>
    <div class="container">
        <section class="filter-card">
            <div class="filter-row">
                <h1>المشـــــــــاريـــــــــــع</h1>
            </div>
            <div class="filter-row">
                <div class="filter-group" data-field="search">
                    <label for="searchInput">اسم المشروع</label>
                    <input type="text" id="searchInput" placeholder="ابحث بالاسم...">
                </div>
                <div class="filter-group" data-field="entity">
                    <label for="entityFilter">الجهة الواردة</label>
                    <select id="entityFilter">
                        <option value="">الكل</option>
                        <option>وزارة الإسكان</option>
                        <option>المؤسسة العامة للمياه</option>
                        <option>هيئة الطرق والمواصلات</option>
                        <option>مديرية الخدمات الفنية</option>
                    </select>
                </div>
                <div class="filter-group" data-field="contractor">
                    <label for="contractorFilter">المقاول</label>
                    <select id="contractorFilter">
                        <option value="">الكل</option>
                        <option>شركة البناء الحديث</option>
                        <option>مؤسسة الإعمار</option>
                        <option>شركة النور للمقاولات</option>
                        <option>مجموعة الفهد</option>
                    </select>
                </div>
                <div class="filter-group" data-field="dateFrom">
                    <label for="dateFrom">من تاريخ</label>
                    <input type="date" id="dateFrom">
                </div>
                <div class="filter-group" data-field="dateTo">
                    <label for="dateTo">إلى تاريخ</label>
                    <input type="date" id="dateTo">
                </div>
                <div class="filter-group" data-field="sort">
                    <label for="sortSelect">ترتيب حسب</label>
                    <select id="sortSelect">
                        <option value="name">الاسم</option>
                        <option value="startDate">تاريخ البدء</option>
                        <option value="totalSYP">الإجمالي (ل.س)</option>
                        <option value="itemsCount">عدد البنود</option>
                    </select>
                </div>
                <div class="filter-group">
                    <button type="button" class="btn-filter-reset" id="resetFilters">
                        إعادة تعيين
                    </button>
                </div>
            </div>
        </section>

        <div class="projects-grid">
            <div id="projectsContainer" class="projects-container">
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
