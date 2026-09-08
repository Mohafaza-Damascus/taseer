<x-app title="مراقبة الطابور" :vite="['resources/css/admin/queue/index.css']">

    <div class="aq-page">

        {{-- الهيدر --}}
        <header class="aq-header">
            <h1>مراقبة الطابور</h1>
            <a href="{{ route('admin.dashboard') }}" class="aq-back">لوحة التحكم</a>
        </header>

        {{-- ===== الكارد الأولى: الشبابيك ===== --}}
        <section class="aq-card">
            <div class="aq-card-head">
                <h2>النوافذ النشطة</h2>
            </div>

            @if ($counters->isEmpty())
                <p class="aq-empty">لا توجد نوافذ نشطة</p>
            @else
                <div class="aq-counters">
                    @foreach ($counters as $counter)
                        <div class="aq-counter {{ $counter['current_ticket'] ? 'is-busy' : 'is-free' }}">
                            <span class="aq-counter-id">نافذة {{ arabic_numbers($counter['id']) }}</span>

                            @if ($counter['current_ticket'])
                                <span class="aq-counter-ticket">{{ $counter['current_ticket'] }}</span>
                                <span class="aq-counter-service">{{ $counter['current_service'] }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- ===== الكارد التانية: قائمة الانتظار ===== --}}
        <section class="aq-card">
            <div class="aq-card-head">
                <h2>قائمة الانتظار</h2>
                <span class="aq-count">{{ arabic_numbers($waitingTickets->count()) }}</span>
            </div>

            @if ($waitingTickets->isEmpty())
                <p class="aq-empty">لا توجد تذاكر منتظرة</p>
            @else
                <div class="aq-waiting">
                    @foreach ($waitingTickets as $ticket)
                        <div class="aq-wait">
                            <span class="aq-wait-num">{{ $ticket->ticket_number }}</span>
                            <div class="aq-wait-meta">
                                <span class="aq-wait-service">{{ $ticket->service->name }}</span>
                                <span class="aq-wait-time">{{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>

    <script>
        // تحديث حيّ عند تغيّر التذاكر (مع تجميع الدفعات)
        if (window.Echo) {
            let pending = false;
            window.Echo.channel('screen-titckets-updates')
                .listen('.ticket.screen.updated', () => {
                    if (pending) return;
                    pending = true;
                    setTimeout(() => location.reload(), 1500);
                });
        }
    </script>

</x-app>
