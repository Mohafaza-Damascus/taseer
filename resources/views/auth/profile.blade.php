<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>الملف الشخصي</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/profile.css')

</head>


<body>

    <div class="profile-layout">


        {{-- Sidebar --}}

        <aside class="sidebar">

            <div class="sidebar-pattern"></div>

            <div class="sidebar-content">

                <div class="sidebar-header">

                    <a href="{{ route('dashboard') }}" class="sidebar-logo">
                        <img src="{{Vite::asset('resources/images/logo2.png') }}" alt="تسعير">
                    </a>

                </div>


                <nav class="sidebar-nav">

                    <a href="{{ route('dashboard') }}" class="sidebar-link">
                        <span>لوحة التحكم</span>
                    </a>


                    <a href="{{ route('projects.index') }}" class="sidebar-link">
                        <span>المشاريع</span>
                    </a>


                    <a href="{{ route('users.index') }}" class="sidebar-link">
                        <span>المستخدمين</span>
                    </a>


                    <a href="{{ route('roles.index') }}" class="sidebar-link">
                        <span>الأدوار</span>
                    </a>

                    @if(auth()->user()->hasPermission('users.manage'))
                        <a href="{{ route('incoming_entities.index') }}" class="sidebar-link">
                            <span>الجهات الواردة</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('users.manage'))
                        <a href="{{ route('incoming_entities.index') }}" class="sidebar-link">
                            <span>المتعهدين</span>
                        </a>
                    @endif
                </nav>


                <div class="sidebar-footer">

                    <a href="{{ route('profile') }}" class="sidebar-link active">
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

        <main class="profile-main">

            <div class="profile-container">


                {{-- Header --}}

                <header class="profile-header">

                    <span class="profile-label">
                        الحساب
                    </span>

                    <h1>
                        الملف الشخصي
                    </h1>

                    <p>
                        عرض وإدارة معلومات حسابك
                    </p>

                </header>


                {{-- User Information --}}

                <section class="profile-card">

                    <div class="card-heading">

                        <h2>
                            معلومات الحساب
                        </h2>

                    </div>


                    <div class="info-list">

                        <div class="info-row">

                            <span class="info-label">
                                اسم المستخدم
                            </span>

                            <span class="info-value">
                                {{ auth()->user()->username }}
                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                تاريخ إنشاء الحساب
                            </span>

                            <span class="info-value">
                                {{ $user->created_at?->format('Y-m-d') ?? '-' }}
                            </span>

                        </div>

                    </div>

                </section>


                {{-- Roles --}}

                <section class="profile-card">

                    <div class="card-heading">

                        <h2>
                            الأدوار
                        </h2>

                    </div>


                    <div class="chip-list">

                        @forelse ($user->roles as $role)

                            <span class="chip">
                                {{ $role->name }}
                            </span>

                        @empty

                            <span class="empty-text">
                                لا يوجد أدوار
                            </span>

                        @endforelse

                    </div>

                </section>


                {{-- Permissions --}}

                <section class="profile-card">

                    <div class="card-heading">

                        <h2>
                            الصلاحيات
                        </h2>

                    </div>


                    <div class="chip-list">

                        @php
                            $permissions = auth()->user()
                                ->roles
                                ->flatMap(fn($role) => $role->permissions)
                                ->unique('id');
                        @endphp


                        @forelse ($permissions as $permission)

                            <span class="chip">
                                {{ $permission->name }}
                            </span>

                        @empty

                            <span class="empty-text">
                                لا يوجد صلاحيات
                            </span>

                        @endforelse

                    </div>

                </section>


            </div>

        </main>

    </div>

</body>

</html>
