<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>المشاريع</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/dashboard.css')
    @vite('resources/css/projects/index.css')
</head>

<body>

    <div class="admin-layout">

        {{-- Sidebar --}}
        <aside class="sidebar">

            <div class="sidebar-pattern"></div>

            <div class="sidebar-content">

                <div class="sidebar-header">

                    <a href="{{ route('dashboard') }}" class="sidebar-logo">
                        <img src="{{ Vite::asset('resources/images/logo2.png') }}" alt="تسعير">
                    </a>

                    <span>
                        لوحة الإدارة
                    </span>

                </div>


                <nav class="sidebar-nav">

                    <a href="{{ route('dashboard') }}" class="sidebar-link">
                        <span>لوحة التحكم</span>
                    </a>

                    @if(auth()->user()->hasPermission('projects.view'))
                        <a href="{{ route('projects.index') }}" class="sidebar-link active">
                            <span>المشاريع</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('users.manage'))
                        <a href="{{ route('users.index') }}" class="sidebar-link">
                            <span>المستخدمين</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('users.manage'))
                        <a href="{{ route('roles.index') }}" class="sidebar-link">
                            <span>الأدوار</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('users.manage'))
                        <a href="{{ route('incoming_entities.index') }}" class="sidebar-link">
                            <span>الجهات الواردة</span>
                        </a>
                    @endif


                    @if(auth()->user()->hasPermission('users.manage'))
                        <a href="{{ route('contractors.index') }}" class="sidebar-link">
                            <span>المتعهدين</span>
                        </a>
                    @endif
                </nav>


                <div class="sidebar-footer">

                    <a href="{{ route('profile') }}" class="sidebar-link">
                        <span>الملف الشخصي</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="sidebar-link sidebar-logout">
                            <span>تسجيل الخروج</span>
                        </button>

                    </form>

                </div>

            </div>

        </aside>


        {{-- Main Content --}}
        <main class="main-content">

            <div class="container">

                <section class="filter-card">

                    <div class="filter-row">

                        <h1>
                            المشـــــــــاريـــــــــــع
                        </h1>

                    </div>


                    <form method="GET" action="{{ route('projects.index') }}" class="filter-row">

                        <div class="filter-group" data-field="search">

                            <label for="searchInput">
                                اسم المشروع
                            </label>

                            <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                                placeholder="ابحث بالاسم...">

                        </div>


                        <div class="filter-group" data-field="entity">

                            <label for="entityFilter">
                                الجهة الواردة
                            </label>

                            <select id="entityFilter" name="entity">

                                <option value="">
                                    الكل
                                </option>

                                @foreach ($incomingEntities as $entity)

                                    <option value="{{ $entity->id }}" @selected(request('entity') == $entity->id)>
                                        {{ $entity->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="filter-group" data-field="contractor">

                            <label for="contractorFilter">
                                المقاول
                            </label>

                            <select id="contractorFilter" name="contractor">

                                <option value="">
                                    الكل
                                </option>

                                @foreach ($contractors as $contractor)

                                    <option value="{{ $contractor->id }}" @selected(request('contractor') == $contractor->id)>
                                        {{ $contractor->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="filter-group" data-field="dateFrom">

                            <label for="dateFrom">
                                من تاريخ
                            </label>

                            <input type="date" id="dateFrom" name="dateFrom" value="{{ request('dateFrom') }}">

                        </div>


                        <div class="filter-group" data-field="dateTo">

                            <label for="dateTo">
                                إلى تاريخ
                            </label>

                            <input type="date" id="dateTo" name="dateTo" value="{{ request('dateTo') }}">

                        </div>


                        <div class="filter-group" data-field="sort">

                            <label for="sortSelect">
                                ترتيب حسب
                            </label>

                            <select id="sortSelect" name="sort">

                                <option value="name" @selected(request('sort', 'name') === 'name')>
                                    الاسم
                                </option>

                                <option value="startDate" @selected(request('sort') === 'startDate')>
                                    تاريخ البدء
                                </option>

                                <option value="totalSYP" @selected(request('sort') === 'totalSYP')>
                                    الإجمالي (ل.س)
                                </option>

                                <option value="itemsCount" @selected(request('sort') === 'itemsCount')>
                                    عدد البنود
                                </option>

                            </select>

                        </div>


                        <div class="filter-group">

                            <button type="submit" class="btn-filter-reset">
                                تطبيق
                            </button>

                        </div>

                    </form>

                </section>


                <div class="projects-grid">

                    <div id="projectsContainer" class="projects-container">

                        @foreach ($projects as $project)

                            <div class="project-card">

                                <div class="card-header">

                                    <span>
                                        {{ $project->name }}
                                    </span>

                                </div>


                                <div class="card-body">

                                    <div class="info-item">

                                        <label>
                                            الجهة :
                                        </label>

                                        <span>
                                            {{ $project->incomingEntity?->name ?? 'غير محددة' }}
                                        </span>

                                    </div>


                                    <div class="info-item">

                                        <label>
                                            المقاول :
                                        </label>

                                        <span>
                                            {{ $project->contractor?->name ?? 'غير محدد' }}
                                        </span>

                                    </div>

                                </div>


                                <div class="card-footer">

                                    <a href="{{ route('projects.show', $project) }}" class="btn-details">
                                        عرض التفاصيل
                                    </a>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    <a href="{{ route('projects.create') }}" class="add-card" id="addProjectBtn"
                        title="إضافة مشروع جديد">
                        <span class="add-card-icon">
                            +
                        </span>
                    </a>

                </div>


                @if ($projects->hasPages())

                    <div class="pagination">

                        {{ $projects->links() }}

                    </div>

                @endif

            </div>

        </main>

    </div>

</body>

</html>
