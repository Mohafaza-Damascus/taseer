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
            <div id="projectsContainer" class="projects-container"></div>

            <button type="button" class="add-card" id="addProjectBtn" title="إضافة مشروع جديد">
                <span class="add-card-icon">+</span>
            </button>
        </div>

        <div class="no-results" id="noResults">
            <p>لا توجد مشاريع تطابق معايير البحث</p>
        </div>
    </div>

    <script>
        const projectsData = [
            { id: 1,  name: "مشروع بناء مجمع سكني",      entity: "وزارة الإسكان",              contractor: "شركة البناء الحديث",    startDate: "2025-01-15", endDate: "2025-12-30", itemsCount: 45, totalSYP: 125000000, totalUSD: 85000,   status: "نشط" },
            { id: 2,  name: "تجهيز محطة ضخ مياه",        entity: "المؤسسة العامة للمياه",      contractor: "مؤسسة الإعمار",         startDate: "2025-03-10", endDate: "2025-09-20", itemsCount: 28, totalSYP: 78000000,  totalUSD: 52000,   status: "نشط" },
            { id: 3,  name: "صيانة طرق رئيسية",          entity: "هيئة الطرق والمواصلات",      contractor: "شركة النور للمقاولات",  startDate: "2025-02-01", endDate: "2025-06-15", itemsCount: 32, totalSYP: 54000000,  totalUSD: 36000,   status: "قيد التنفيذ" },
            { id: 4,  name: "توريد وتركيب أنظمة إنارة",  entity: "مديرية الخدمات الفنية",      contractor: "مجموعة الفهد",          startDate: "2025-04-20", endDate: "2025-08-30", itemsCount: 18, totalSYP: 32000000,  totalUSD: 21000,   status: "نشط" },
            { id: 5,  name: "ترميم مبنى أثري",           entity: "وزارة الإسكان",              contractor: "مؤسسة الإعمار",         startDate: "2025-05-05", endDate: "2025-11-30", itemsCount: 55, totalSYP: 98000000,  totalUSD: 65000,   status: "نشط" },
            { id: 6,  name: "إنشاء شبكة صرف صحي",        entity: "المؤسسة العامة للمياه",      contractor: "شركة البناء الحديث",    startDate: "2025-06-01", endDate: "2026-02-28", itemsCount: 40, totalSYP: 150000000, totalUSD: 102000,  status: "مؤجل" },
            { id: 7,  name: "تطوير حديقة عامة",          entity: "مديرية الخدمات الفنية",      contractor: "شركة النور للمقاولات",  startDate: "2025-07-10", endDate: "2025-10-15", itemsCount: 22, totalSYP: 41000000,  totalUSD: 27000,   status: "نشط" },
            { id: 8,  name: "بناء مدرسة ثانوية",         entity: "وزارة الإسكان",              contractor: "مجموعة الفهد",          startDate: "2025-08-01", endDate: "2026-05-30", itemsCount: 60, totalSYP: 200000000, totalUSD: 135000,  status: "نشط" },
            { id: 9,  name: "تأهيل شبكة كهرباء",         entity: "هيئة الطرق والمواصلات",      contractor: "شركة البناء الحديث",    startDate: "2025-03-15", endDate: "2025-12-31", itemsCount: 35, totalSYP: 89000000,  totalUSD: 59000,   status: "نشط" },
            { id: 10, name: "مشروع ري المناطق الزراعية", entity: "المؤسسة العامة للمياه",      contractor: "مؤسسة الإعمار",         startDate: "2025-09-01", endDate: "2026-08-30", itemsCount: 48, totalSYP: 175000000, totalUSD: 118000,  status: "مخطط" },
            { id: 11, name: "توسعة مستشفى عام",          entity: "وزارة الإسكان",              contractor: "شركة النور للمقاولات",  startDate: "2025-10-01", endDate: "2027-04-30", itemsCount: 75, totalSYP: 320000000, totalUSD: 215000,  status: "مخطط" },
            { id: 12, name: "أعمال تعبيد طرق فرعية",     entity: "هيئة الطرق والمواصلات",      contractor: "مجموعة الفهد",          startDate: "2025-04-01", endDate: "2025-08-31", itemsCount: 20, totalSYP: 38000000,  totalUSD: 25000,   status: "مكتمل" }
        ];

        const statusConfig = {
            "نشط":         { badge: "badge-active",   color: "var(--color-green-500)"  },
            "قيد التنفيذ": { badge: "badge-progress", color: "var(--color-amber-500)"  },
            "مخطط":        { badge: "badge-planned",  color: "var(--color-blue-500)"   },
            "مؤجل":        { badge: "badge-delayed",  color: "var(--color-red-500)"    },
            "مكتمل":       { badge: "badge-completed",color: "var(--color-charcoal-400)" }
        };

        const filterLabels = {
            search: v => `الاسم: ${v}`,
            entity: v => `الجهة: ${v}`,
            contractor: v => `المقاول: ${v}`,
            dateFrom: v => `من: ${v}`,
            dateTo: v => `إلى: ${v}`
        };

        // ==================== أدوات ====================
        const formatNumber = (num) => num.toLocaleString('ar-SY');

        function projectProgress(project) {
            const start = new Date(project.startDate).getTime();
            const end = new Date(project.endDate).getTime();
            const now = Date.now();
            if (project.status === "مكتمل") return 100;
            if (now <= start) return 0;
            if (now >= end) return 100;
            return Math.round(((now - start) / (end - start)) * 100);
        }

        // ==================== العرض ====================
        function renderCards(projects) {
            const container = document.getElementById('projectsContainer');
            const noResults = document.getElementById('noResults');
            container.innerHTML = '';

            noResults.style.display = projects.length === 0 ? 'block' : 'none';

            projects.forEach(project => {
                const cfg = statusConfig[project.status] || statusConfig["مخطط"];
                const progress = projectProgress(project);

                container.insertAdjacentHTML('beforeend', `
                    <div class="project-card" style="--spine-color:${cfg.color}">
                        <div class="card-header">
                            <span>${project.name}</span>
                        </div>
                        <div class="card-body">
                            <div class="info-item">
                                <label>الجهة :</label>
                                <span>${project.entity}</span>
                            </div>
                            <div class="info-item">
                                <label>المقاول :</label>
                                <span>${project.contractor}</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn-details">
                                عرض التفاصيل
                            </button>
                        </div>
                    </div>
                `);
            });

            document.getElementById('grandTotal').textContent =
                formatNumber(projects.reduce((sum, p) => sum + p.totalSYP, 0)) + ' ل.س';
            document.getElementById('resultsCount').textContent = projects.length;
        }


        // ==================== الفلترة والفرز ====================
        function applyFiltersAndSort() {
            const values = {
                search:     document.getElementById('searchInput').value.trim(),
                entity:     document.getElementById('entityFilter').value,
                contractor: document.getElementById('contractorFilter').value,
                dateFrom:   document.getElementById('dateFrom').value,
                dateTo:     document.getElementById('dateTo').value
            };
            const sortBy = document.getElementById('sortSelect').value;

            document.querySelectorAll('.filter-group[data-field]').forEach(group => {
                const field = group.dataset.field;
                const control = group.querySelector('input, select');
                group.classList.toggle('has-value', !!(control && control.value));
            });

            const filtered = projectsData.filter(project => {
                if (values.search && !project.name.toLowerCase().includes(values.search.toLowerCase())) return false;
                if (values.entity && project.entity !== values.entity) return false;
                if (values.contractor && project.contractor !== values.contractor) return false;
                if (values.dateFrom && project.startDate < values.dateFrom) return false;
                if (values.dateTo && project.endDate > values.dateTo) return false;
                return true;
            });

            const sortFns = {
                name:      (a, b) => a.name.localeCompare(b.name, 'ar'),
                startDate: (a, b) => a.startDate.localeCompare(b.startDate),
                totalSYP:  (a, b) => b.totalSYP - a.totalSYP,
                itemsCount:(a, b) => b.itemsCount - a.itemsCount
            };
            filtered.sort(sortFns[sortBy] || sortFns.name);

            renderCards(filtered);
        }

        // ==================== الأحداث ====================
        ['searchInput', 'entityFilter', 'contractorFilter', 'dateFrom', 'dateTo', 'sortSelect']
            .forEach(id => {
                const el = document.getElementById(id);
                el.addEventListener(el.tagName === 'INPUT' && el.type === 'text' ? 'input' : 'change', applyFiltersAndSort);
            });

        document.getElementById('resetFilters').addEventListener('click', () => {
            document.getElementById('searchInput').value = '';
            document.getElementById('entityFilter').value = '';
            document.getElementById('contractorFilter').value = '';
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
            document.getElementById('sortSelect').value = 'name';
            applyFiltersAndSort();
        });

        document.getElementById('addProjectBtn').addEventListener('click', () => {
            // TODO: توجيه لصفحة إضافة مشروع أو فتح مودال
            console.log('إضافة مشروع جديد');
        });

        // العرض الأولي
        applyFiltersAndSort();
    </script>
</body>
</html>
