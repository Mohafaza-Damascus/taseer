<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>الجهات الواردة</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/dashboard.css')
    @vite('resources/css/admin/incoming_entities/index.css')
</head>

<body>

    <div class="admin-layout">

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
                        <a href="{{ route('incoming_entities.index') }}" class="sidebar-link active">
                            <span>الجهات الواردة</span>
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
                        الجهات الواردة
                    </h1>

                    <a
                        href="{{ route('dashboard') }}"
                        class="btn-go-back"
                    >
                        رجوع
                    </a>

                </section>


                @if ($incomingEntities->isEmpty())

                    <div class="no-results">
                        <p>
                            لا يوجد جهات واردة
                        </p>
                    </div>

                @else

                    <div class="cards-grid">

                        @foreach ($incomingEntities as $incomingEntity)

                            <div class="card">

                                <span class="card-title">
                                    {{ $incomingEntity->name }}
                                </span>

                                <span class="card-subtitle">
                                    ملاحظات : {{ $incomingEntity->notes }}
                                </span>

                                <div class="card-footer">

                                    <a
                                        href="{{ route('incoming_entities.show', $incomingEntity) }}"
                                        class="btn-details"
                                    >
                                        عرض التفاصيل
                                    </a>

                                </div>

                            </div>

                        @endforeach


                        <a
                            href="{{ route('incoming_entities.create') }}"
                            class="add-card"
                            title="إضافة جهة واردة جديدة"
                        >
                            <span class="add-card-icon">
                                +
                            </span>
                        </a>

                    </div>

                @endif


            </div>

        </main>

    </div>

</body>

</html>
