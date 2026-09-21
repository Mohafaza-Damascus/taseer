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
                        <img src="{{ asset('../../resources/images/logo2.png') }}" alt="تسعير">
                    </a>

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


                    @if(auth()->user()->hasPermission('role.manage'))
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
                        <h1>
                            لوحة التحكم
                        </h1>
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

                        </div>


                        <div class="stat-card">

                            <div class="stat-card-top">
                                <span class="stat-title">
                                    الجهات الواردة
                                </span>
                            </div>

                            <strong class="stat-value">
                                {{ $incomingEntitiesCount }}
                            </strong>

                        </div>

                        <div class="stat-card">

                            <div class="stat-card-top">
                                <span class="stat-title">
                                    المتعهدين
                                </span>
                            </div>

                            <strong class="stat-value">
                                {{ $contractorsCount }}
                            </strong>


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
                                </div>
                            </a>
                        @endif


                        @if(auth()->user()->hasPermission('users.manage'))
                            <a href="{{ route('users.index') }}" class="quick-link">


                                <div>
                                    <strong>المستخدمين</strong>
                                </div>
                            </a>
                        @endif


                        @if(auth()->user()->hasPermission('role.manage'))
                            <a href="{{ route('roles.index') }}" class="quick-link">


                                <div>
                                    <strong>الأدوار</strong>
                                </div>
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('users.manage'))
                            <a href="{{ route('incoming_entities.index') }}" class="quick-link">
                                <div>
                                    <strong>الجهات الواردة</strong>
                                </div>
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('users.manage'))
                            <a href="{{ route('contractors.index') }}" class="quick-link">
                                <div>
                                    <strong>المتعهدين</strong>
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
