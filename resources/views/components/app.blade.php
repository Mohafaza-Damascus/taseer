<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    {{-- استعادة حالة السايدبار قبل أول رسم — يمنع وميض الفتح ثم السكر عند الريفرش --}}
    <script>
        try {
            if (localStorage.getItem('sidebar-hidden') === '1') {
                document.documentElement.classList.add('sidebar-init-collapsed');
            }
        } catch (e) {}
    </script>
    @vite('resources/js/app.js')
    @vite('resources/css/variables.css')
    @vite('resources/css/app.css')
    @vite('resources/css/components/forms.css')
    @vite('resources/css/toast.css')
    @if (isset($vite))
        @foreach ($vite as $file)
            @vite($file)
        @endforeach
    @endif
</head>

<body class="app-body">
    <div class="layout" id="appLayout">

        <button class="sidebar-toggle" onclick="toggleSidebar()" title="إخفاء/إظهار القائمة">
            <img src=" {{ Vite::asset('resources/images/sidebar-golden-wheat-100.svg') }} " alt=""
                class="sidebar-toggle-icon">
        </button>

        <aside class="sidebar" id="sidebar">
            <a href="{{ route('welcome') }}" class="sidebar-brand">
                <img src="{{ Vite::asset('resources/images/damascus-eagle.png') }}" alt="محافظة دمشق" class="sidebar-logo">
                <div class="sidebar-brand-text">
                    <span class="sidebar-gov">محافظة دمشق</span>
                    <span class="sidebar-text">دَوْر</span>
                </div>
            </a>

            <nav class="sidebar-nav">
                <a href="{{ route('counters.live') }}"
                    class="sidebar-item {{ request()->is('counters*') ? 'active' : '' }}">
                    <img src="{{ Vite::asset('resources/images/monitor-golden-wheat-100.svg') }}" alt="">
                    <span>الشاشة العامة</span>
                </a>
                @auth
                    @if (auth()->user()->isReception())
                        <a href="{{ route('services.index') }}"
                            class="sidebar-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                            <img src="{{ Vite::asset('resources/images/stack-golden-wheat-100.svg') }}" alt="">
                            <span>الخدمات</span>
                        </a>
                    @endif

                    @if (auth()->user()->isAgent())
                        <a href="{{ route('queue.index') }}"
                            class="sidebar-item {{ request()->routeIs('queue.*') ? 'active' : '' }}">
                            <img src="{{ Vite::asset('resources/images/queue-golden-wheat-100.svg') }}" alt="">
                            <span>الطابور</span>
                        </a>
                    @endif

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <img src="{{ Vite::asset('resources/images/gear-golden-wheat-100.svg') }}" alt="">
                            <span>لوحة التحكم</span>
                        </a>
                    @endif
                @endauth
            </nav>

            @auth
                <div class="sidebar-footer">
                    <div class="sidebar-user">
                        <div class="sidebar-user-info">
                            <span class="sidebar-name">{{ auth()->user()->username }}</span>
                            <span class="sidebar-role">
                                @if (auth()->user()->isAdmin())
                                    مدير النظام
                                @elseif(auth()->user()->isReception())
                                    موظف استقبال
                                @else
                                    موظف خدمة
                                @endif
                            </span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-logout" title="تسجيل خروج">
                            <img src="{{ Vite::asset('resources/images/hand-waving-pineal-700.svg') }}" alt="">
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        {{-- Main --}}
        <main class="main">
            <div class="toast-overlay">
                @if (session('success'))
                    <div class="toast toast-success">
                        <img src="{{ Vite::asset('resources/images/check-circle-golden-wheat-100.svg') }}"
                            class="toast-icon" alt="">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.closest('.toast').remove()">
                            <img src="{{ Vite::asset('resources/images/x.svg') }}" alt="إغلاق"
                                class="toast-close-icon">
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="toast toast-error">
                        <img src="{{ Vite::asset('resources/images/x-circle-golden-wheat-100.svg') }}"
                            class="toast-icon" alt="">
                        <span>{{ session('error') }}</span>
                        <button onclick="this.closest('.toast').remove()">
                            <img src="{{ Vite::asset('resources/images/x.svg') }}" alt="إغلاق"
                                class="toast-close-icon">
                        </button>
                    </div>
                @endif
            </div>
            {{ $slot }}
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const layout = document.getElementById('appLayout');

            sidebar.classList.toggle('sidebar-hidden');
            layout.classList.toggle('sidebar-collapsed');

            const isHidden = sidebar.classList.contains('sidebar-hidden');
            localStorage.setItem('sidebar-hidden', isHidden ? '1' : '0');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const isHidden = localStorage.getItem('sidebar-hidden') === '1';
            if (isHidden) {
                document.getElementById('sidebar').classList.add('sidebar-hidden');
                document.getElementById('appLayout').classList.add('sidebar-collapsed');
            }
            // الكلاسات الحقيقية استلمت الحالة الآن — نشيل حالة ما-قبل-الرسم (نفس المنظر، بلا وميض)
            document.documentElement.classList.remove('sidebar-init-collapsed');
        });
    </script>

</body>

</html>
