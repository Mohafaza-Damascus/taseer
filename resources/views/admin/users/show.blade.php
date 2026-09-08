<x-app title="{{ $user->username }}">
    @vite('resources/css/admin/users/show.css')

    <div class="user-show-page">

        {{-- Header --}}
        <div class="user-show-header">
            <div class="user-show-header-info">
                <h1>{{ $user->username }}</h1>
            </div>
            <a href="{{ route('admin.users.index') }}" class="user-show-back">رجوع</a>
        </div>

        {{-- User Info --}}
        <div class="user-show-card user-show-info">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">النافذة</span>
                    <span class="info-value">{{ $user->counter ? 'نافذة ' . $user->counter->id : '—' }}</span>
                </div>
                <div class="info-item info-item-wide">
                    <span class="info-label">الخدمات المسندة</span>
                    <div class="info-services">
                        @forelse($user->services as $service)
                            <span class="service-badge">{{ $service->name }}</span>
                        @empty
                            <span class="info-value">—</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="user-show-card user-show-filters">
            <h2 class="section-title">تصفية النشاطات</h2>
            <form method="GET" action="{{ route('admin.users.show', $user) }}" class="filters-form" id="filterForm">

                {{-- Date Preset --}}
                <div class="filter-section">
                    <label class="filter-section-label">الفترة الزمنية</label>
                    <div class="preset-chips">
                        @php
                            $presets = [
                                'today' => 'اليوم',
                                'yesterday' => 'أمس',
                                'last7' => 'آخر 7 أيام',
                                'last30' => 'آخر 30 يوم',
                                'this_month' => 'هذا الشهر',
                                'last_month' => 'الشهر الماضي',
                                'custom' => 'مخصص',
                            ];
                            $currentPreset = request('date_preset', 'last7');
                        @endphp
                        @foreach($presets as $value => $label)
                            <label class="preset-chip {{ $currentPreset === $value ? 'active' : '' }}">
                                <input type="radio" name="date_preset" value="{{ $value }}" {{ $currentPreset === $value ? 'checked' : '' }} onchange="handlePresetChange(this)">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="custom-date-range {{ $currentPreset === 'custom' ? 'visible' : '' }}" id="customDateRange">
                        <div class="date-inputs">
                            <div class="date-field">
                                <label class="filter-label">من</label>
                                <input type="date" name="start_date" id="startDateInput" value="{{ request('start_date') }}" class="filter-input">
                            </div>
                            <div class="date-field">
                                <label class="filter-label">إلى</label>
                                <input type="date" name="end_date" id="endDateInput" value="{{ request('end_date') }}" class="filter-input">
                            </div>
                        </div>
                        <div class="filters-actions">
                            <button type="submit" class="btn btn-primary">تطبيق</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="user-show-summary">
            <div class="summary-card">
                <span class="summary-value">{{ $summary['total_tickets'] }}</span>
                <span class="summary-label">إجمالي التذاكر</span>
            </div>
            <div class="summary-card summary-success">
                <span class="summary-value">{{ $summary['completed_tickets'] }}</span>
                <span class="summary-label">منتهية</span>
            </div>
            <div class="summary-card summary-danger">
                <span class="summary-value">{{ $summary['cancelled_tickets'] }}</span>
                <span class="summary-label">ملغاة</span>
            </div>
        </div>

        {{-- Tickets Table --}}
        <div class="user-show-card user-show-table-card">
            <h2 class="section-title">سجل التذاكر</h2>
            <div class="table-wrapper">
                <table class="user-show-table">
                    <thead>
                        <tr>
                            <th>رقم التذكرة</th>
                            <th>الخدمة</th>
                            <th>الحالة</th>
                            <th>وقت الإنشاء</th>
                            <th>وقت النداء</th>
                            <th>وقت الإنهاء</th>
                            <th>وقت الانتظار</th>
                            <th>وقت الخدمة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ticketsData as $ticket)
                            <tr>
                                <td class="ticket-number">{{ $ticket['ticket_number'] }}</td>
                                <td class="service-cell">{{ $ticket['service']['name'] ?? $ticket['service']['code'] }}</td>
                                <td>
                                    @php
                                        $statusClass = match($ticket['status']) {
                                            'completed' => 'status-completed',
                                            'serving' => 'status-serving',
                                            'cancelled' => 'status-cancelled',
                                            default => 'status-waiting',
                                        };
                                        $statusLabel = match($ticket['status']) {
                                            'completed' => 'منتهية',
                                            'serving' => 'قيد الخدمة',
                                            'cancelled' => 'ملغاة',
                                            default => 'منتظرة',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                </td>
                                <td dir="ltr" class="time-cell">{{ $ticket['created_at'] ? \Carbon\Carbon::parse($ticket['created_at'])->format('Y-m-d H:i') : '—' }}</td>
                                <td dir="ltr" class="time-cell">{{ $ticket['called_at'] ? \Carbon\Carbon::parse($ticket['called_at'])->format('Y-m-d H:i') : '—' }}</td>
                                <td dir="ltr" class="time-cell">{{ $ticket['completed_at'] ? \Carbon\Carbon::parse($ticket['completed_at'])->format('Y-m-d H:i') : '—' }}</td>
                                <td dir="ltr" class="time-cell highlight-wait">{{ $ticket['wait_time'] ?? '—' }}</td>
                                <td dir="ltr" class="time-cell highlight-serve">{{ $ticket['service_time'] ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="table-empty">
                                    <div class="empty-state">
                                        <p>لا توجد تذاكر مطابقة للفلاتر المحددة</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function handlePresetChange(radio) {
            // Update active visual state
            document.querySelectorAll('.preset-chip').forEach(chip => {
                chip.classList.remove('active');
            });
            radio.closest('.preset-chip').classList.add('active');

            const customRange = document.getElementById('customDateRange');

            if (radio.value === 'custom') {
                // Show the calendar inputs and stop here — user picks dates
                // then clicks "تطبيق" (Apply) to submit and refresh the table.
                customRange.classList.add('visible');
            } else {
                customRange.classList.remove('visible');
                // Auto-submit for non-custom presets
                document.getElementById('filterForm').submit();
            }
        }
    </script>
</x-app>
