<x-app title="لوحة التحكم" :vite="['resources/css/admin/dashboard.css']">
    <div class="dash">

        <div class="dash-head">
            <h1>لوحة التحكم</h1>
        </div>

        <div class="dash-section">
            <span class="dash-section-label">النوافذ</span>
            <div class="dash-stats">
                <div class="stat-item">
                    <span class="stat-val">{{ arabic_numbers($activeCounters) }}</span>
                    <span class="stat-lbl">نشط</span>
                </div>
                <div class="stat-item stat-inactive">
                    <span class="stat-val">{{ arabic_numbers($inactiveCounters) }}</span>
                    <span class="stat-lbl">غير نشط</span>
                </div>
            </div>
        </div>

        <div class="dash-section">
            <span class="dash-section-label">الخدمات</span>
            <div class="dash-stats">
                <div class="stat-item">
                    <span class="stat-val">{{ arabic_numbers($activeServices) }}</span>
                    <span class="stat-lbl">نشط</span>
                </div>
                <div class="stat-item stat-inactive">
                    <span class="stat-val">{{ arabic_numbers($inactiveServices) }}</span>
                    <span class="stat-lbl">غير نشط</span>
                </div>
            </div>
        </div>

        <div class="dash-section">
            <span class="dash-section-label">التذاكر</span>
            <div class="dash-stats">
                <div class="stat-item">
                    <span class="stat-val">{{ arabic_numbers($waitingTickets) }}</span>
                    <span class="stat-lbl">قيد الانتظار</span>
                </div>
                <div class="stat-item">
                    <span class="stat-val">{{ arabic_numbers($servingTickets) }}</span>
                    <span class="stat-lbl">قيد الخدمة</span>
                </div>
                <div class="stat-item">
                    <span class="stat-val">{{ arabic_numbers($completedToday) }}</span>
                    <span class="stat-lbl">مكتملة اليوم</span>
                </div>
                <div class="stat-item">
                    <span class="stat-val">
                        @php
                            $total = $avgWaitSeconds;
                            $h = floor($total / 3600);
                            $m = floor(($total % 3600) / 60);
                            $s = $total % 60;
                        @endphp
                        @if ($h > 0)
                            {{ arabic_numbers($h) }}:{{ arabic_numbers(str_pad($m, 2, '0', STR_PAD_LEFT)) }}:{{ arabic_numbers(str_pad($s, 2, '0', STR_PAD_LEFT)) }}
                        @else
                            {{ arabic_numbers(str_pad($m, 2, '0', STR_PAD_LEFT)) }}:{{ arabic_numbers(str_pad($s, 2, '0', STR_PAD_LEFT)) }}
                        @endif
                    </span>
                    <span class="stat-lbl">متوسط الانتظار</span>
                </div>
            </div>
        </div>

        <div class="dash-section">
            <span class="dash-section-label">إدارة النظام</span>
            <div class="dash-links">
                <a href="{{ route('admin.queue.overview') }}" class="dash-link">
                    <div class="dash-link-icon">
                        <img src="{{ Vite::asset('resources/images/queue-golden-wheat-100.svg') }}" alt="">
                    </div>
                    <span>الطابور</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="dash-link">
                    <div class="dash-link-icon">
                        <img src="{{ Vite::asset('resources/images/user-golden-wheat-100.svg') }}" alt="">
                    </div>
                    <span>المستخدمين</span>
                </a>
                <a href="{{ route('admin.services.index') }}" class="dash-link">
                    <div class="dash-link-icon">
                        <img src="{{ Vite::asset('resources/images/stack-golden-wheat-100.svg') }}" alt="">
                    </div>
                    <span>الخدمات</span>
                </a>
                <a href="{{ route('admin.counters.index') }}" class="dash-link">
                    <div class="dash-link-icon">
                        <img src="{{ Vite::asset('resources/images/projector-screen-golden-wheat-100.svg') }}" alt="">
                    </div>
                    <span>النوافذ</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="dash-link">
                    <div class="dash-link-icon">
                        <img src="{{ Vite::asset('resources/images/gear-golden-wheat-100.svg') }}" alt="">
                    </div>
                    <span>الإعدادات</span>
                </a>
            </div>
        </div>

    </div>
</x-app>
