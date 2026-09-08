<x-app title="دور" :vite="['resources/css/index.css']">

    @guest
        <div class="home">
            <div class="home-center">
                <h1>دَوْر</h1>
                <p>لتنظيم دور مركز خدمة المواطن</p>
                <div class="home-btns">
                    <a href="{{ route('show.login') }}" class="home-btn home-btn-primary">تسجيل الدخول</a>
                </div>
            </div>
        </div>
    @endguest

    @auth
        <div class="home">
            <div class="home-center">
                <h1>مرحباً {{ auth()->user()->username }}</h1>
            </div>

            @if (auth()->user()->isReception())
                    <div class="home-stats-grid">
                        <div class="stat-card">
                            <span class="stat-value">{{ arabic_numbers($stats['total_issued_today']) }}</span>
                            <span class="stat-label">تذكرة صدرت اليوم</spa`n>
                        </div>
                        <div class="stat-card">
                            <span class="stat-value">{{ arabic_numbers($stats['total_waiting_now']) }}</span>
                            <span class="stat-label">مواطن في الانتظار</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-value">{{ arabic_numbers($stats['active_services']) }}</span>
                            <span class="stat-label">خدمة متاحة</span>
                        </div>
                    </div>
                    <div class="home-actions">
                        <a href="{{ route('services.index') }}" class="home-btn home-btn-primary">إصدار تذكرة جديدة</a>
                    </div>
            @endif

            @if (auth()->user()->isAgent())
                    <div class="home-stats-grid">
                        <div class="stat-card">
                            <span class="stat-value">{{ arabic_numbers($stats['waiting_for_me']) }}</span>
                            <span class="stat-label">في انتظارك</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-value">{{ arabic_numbers($stats['served_by_me_today']) }}</span>
                            <span class="stat-label">معاملة أنجزتها</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-value">{{ auth()->user()->counter_id ? arabic_numbers(auth()->user()->counter_id) : '-' }}</span>
                            <span class="stat-label">نافذتك الحالية</span>
                        </div>
                    </div>
                    <div class="home-actions">
                        <a href="{{ route('queue.index') }}" class="home-btn home-btn-primary">استدعاء التذكرة التالية</a>
                    </div>
            @endif

            @if (auth()->user()->isAdmin())
                    <div class="home-stats-grid grid-4">
                        <div class="stat-card">
                            <span class="stat-value">{{ arabic_numbers($stats['total_tickets_today']) }}</span>
                            <span class="stat-label">إجمالي تذاكر اليوم</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-value">{{ arabic_numbers($stats['active_counters']) }}</span>
                            <span class="stat-label">النوافذ النشطة</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-value">{{ arabic_numbers($stats['total_users']) }}</span>
                            <span class="stat-label">إجمالي الموظفين</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-value">{{ arabic_numbers($stats['total_services']) }}</span>
                            <span class="stat-label">إجمالي الخدمات</span>
                        </div>
                    </div>
                    <div class="home-actions">
                        <a href="{{ route('admin.dashboard') }}" class="home-btn home-btn-primary">الانتقال إلى لوحة التحكم</a>
                    </div>
            @endif

        </div>
    @endauth

</x-app>
