<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>لوحة التحكم</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/dashboard.css')
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

                    <a href="{{ route('dashboard') }}" class="sidebar-link active">

                        <span>لوحة التحكم</span>
                    </a>


                    @if(auth()->user()->hasPermission('projects.view'))
                        <a href="{{ route('projects.index') }}" class="sidebar-link">

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

            <div class="dashboard">

                <header class="dashboard-header">

                    <div>
                        <span class="dashboard-label">
                            الإدارة
                        </span>

                        <h1>
                            لوحة التحكم
                        </h1>

                        <p>
                            نظرة عامة على نظام تسعير
                        </p>
                    </div>

                </header>


                {{-- Statistics --}}

                <section class="dashboard-section">

                    <div class="section-heading">
                        <h2>الإحصائيات</h2>
                    </div>


                    <div class="stats-grid">

                        <div class="stat-card">

                            <div class="stat-card-top">
                                <span class="stat-title">
                                    المستخدمين
                                </span>

                            </div>

                            <strong class="stat-value">
                                {{ $usersCount }}
                            </strong>

                            <span class="stat-description">
                                إجمالي المستخدمين
                            </span>

                        </div>


                        <div class="stat-card">

                            <div class="stat-card-top">
                                <span class="stat-title">
                                    الأدوار
                                </span>


                            </div>

                            <strong class="stat-value">
                                {{ $rolesCount }}
                            </strong>

                            <span class="stat-description">
                                إجمالي الأدوار
                            </span>

                        </div>


                        <div class="stat-card">

                            <div class="stat-card-top">
                                <span class="stat-title">
                                    المشاريع
                                </span>
                            </div>

                            <strong class="stat-value">
                                {{ $projectsCount }}
                            </strong>

                            <span class="stat-description">
                                إجمالي المشاريع
                            </span>

                        </div>

                    </div>

                </section>


                {{-- Quick Access --}}

                <section class="dashboard-section">

                    <div class="section-heading">
                        <h2>الوصول السريع</h2>
                    </div>


                    <div class="quick-links">

                        @if(auth()->user()->hasPermission('projects.view'))
                            <a href="{{ route('projects.index') }}" class="quick-link">


                                <div>
                                    <strong>المشاريع</strong>
                                    <span>إدارة المشاريع والتسعير</span>
                                </div>
                            </a>
                        @endif


                        @if(auth()->user()->hasPermission('users.manage'))
                            <a href="{{ route('users.index') }}" class="quick-link">


                                <div>
                                    <strong>المستخدمين</strong>
                                    <span>إدارة المستخدمين والأدوار</span>
                                </div>
                            </a>
                        @endif


                        @if(auth()->user()->hasPermission('users.manage'))
                            <a href="{{ route('roles.index') }}" class="quick-link">


                                <div>
                                    <strong>الأدوار</strong>
                                    <span>إدارة الأدوار والصلاحيات</span>
                                </div>
                            </a>
                        @endif

                    </div>

                </section>

            </div>

        </main>

    </div>

</body>

</html>
