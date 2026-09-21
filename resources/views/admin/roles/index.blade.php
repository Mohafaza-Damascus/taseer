<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>الأدوار</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/dashboard.css')
    @vite('resources/css/admin/users/index.css')
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

                    <a href="{{ route('dashboard') }}" class="sidebar-link">
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
                        <a href="{{ route('roles.index') }}" class="sidebar-link active">
                            <span>الأدوار</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('incoming_entities.view'))
                        <a href="{{ route('incoming_entities.index') }}" class="sidebar-link">
                            <span>الجهات الواردة</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('contractors.view'))
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

                <section class="header-card">

                    <h1>
                        الأدوار
                    </h1>

                </section>

                <div class="cards-grid">

                    @foreach ($roles as $role)

                        <div class="card">

                            <span class="card-title">
                                {{ $role->name }}
                            </span>

                            <span class="card-subtitle">
                                {{ $role->slug }}
                            </span>

                            <div class="card-footer">

                                <a href="{{ route('roles.show', $role) }}" class="btn-details">
                                    عرض التفاصيل
                                </a>

                            </div>

                        </div>

                    @endforeach

                    @if(auth()->user()->hasPermission('role.manage'))
                        <a href="{{ route('roles.create') }}" class="add-card" title="إضافة دور جديد">
                            <span class="add-card-icon">
                                +
                            </span>
                        </a>
                    @endif

                </div>

            </div>

        </main>

    </div>

</body>

</html>