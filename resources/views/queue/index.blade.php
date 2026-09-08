<x-app title="الطابور" :vite="['resources/css/queue/index.css']">

    <div class="queue-screen">

        @if (auth()->user()->counter && !auth()->user()->counter->is_active)
            <div class="queue-header">
                <div>
                    <h1>الطابور</h1>
                </div>
                <form action="{{ route('queue.toggle-counter') }}" method="POST">
                    @csrf
                    <button type="submit" class="queue-counter-toggle inactive">
                        نافذة {{ arabic_numbers(auth()->user()->counter_id) }}
                    </button>
                </form>
            </div>
            <div class="queue-current-offline">
                <img src="{{ Vite::asset('resources/images/x-circle-umber-700.svg') }}" alt="">
                <span>النافذة غير نشطة</span>
            </div>
        @endif

        @if (auth()->user()->counter && auth()->user()->counter->is_active)
            <div class="queue-header">
                <div>
                    <h1>الطابور</h1>
                </div>
                <form action="{{ route('queue.toggle-counter') }}" method="POST">
                    @csrf
                    <button type="submit" class="queue-counter-toggle active">
                        نافذة {{ arabic_numbers(auth()->user()->counter_id) }}
                    </button>
                </form>
            </div>

            <div class="queue-current">
                @if ($currentTicket)
                    <div class="queue-current-card">
                        <span class="queue-current-label">قيد الخدمة</span>

                        <div class="queue-current-row">
                            <span class="queue-current-number">{{ $currentTicket->ticket_number }}</span>
                            <span class="queue-current-service">{{ $currentTicket->service->name }}</span>
                        </div>

                        <div class="queue-bottom-row">
                            <div class="queue-timer"
                                data-served-at="{{ $currentTicket->served_at?->timestamp ?? ($currentTicket->called_at?->timestamp ?? now()->timestamp) }}">
                                <span class="queue-timer-text" id="serviceTimer">٠٠:٠٠</span>
                            </div>

                            <div class="queue-current-actions">
                                <form action="{{ route('queue.call-again', $currentTicket) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="queue-btn queue-btn-call">نداء</button>
                                </form>
                                <button type="button" class="queue-btn queue-btn-transfer"
                                    onclick="openTransferModal()">تحويل</button>
                                <form action="{{ route('queue.return', $currentTicket) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="queue-btn queue-btn-return">إرجاع</button>
                                </form>
                                <form action="{{ route('queue.complete', $currentTicket) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="queue-btn queue-btn-complete">إنهاء</button>
                                </form>
                                <form action="{{ route('queue.complete-and-next', $currentTicket) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="queue-btn queue-btn-complete">إنهاء + التالي</button>
                                </form>

                            </div>
                        </div>

                    </div>
                @else
                    <div class="queue-current-empty">
                        <img src="{{ Vite::asset('resources/images/ticket-pineal-700.svg') }}" alt="">
                        <span>لا توجد تذكرة حالية</span>
                        <form action="{{ route('queue.call-next') }}" method="POST">
                            @csrf
                            <button type="submit" class="queue-btn queue-btn-next">استدعاء التالي</button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="queue-waiting">
                <div class="queue-waiting-header">
                    <div class="queue-waiting-title-group">
                        <h2>قائمة الانتظار</h2>
                        <span class="queue-count-badge">{{ arabic_numbers($waitingTickets->count()) }}</span>
                    </div>

                    <form method="GET" class="queue-filter">
                        <select name="service" onchange="this.form.submit()">
                            <option value="">كل الخدمات</option>
                            @foreach (auth()->user()->services as $service)
                                <option value="{{ $service->code }}"
                                    {{ request('service') == $service->code ? 'selected' : '' }}>
                                    {{ $service->code }} - {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="queue-waiting-list">
                    @forelse($waitingTickets as $ticket)
                        <div class="queue-waiting-item">
                            <div class="queue-waiting-info">
                                <span class="queue-waiting-number">{{ $ticket->ticket_number }}</span>
                                <div class="queue-waiting-meta">
                                    <span class="queue-waiting-service">{{ $ticket->service->name }}</span>
                                    <span class="queue-waiting-time">{{ $ticket->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="queue-waiting-actions">
                                <form action="{{ route('queue.delete', $ticket) }}" method="POST"
                                    onsubmit="return confirm('حذف التذكرة {{ $ticket->ticket_number }}؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="queue-btn queue-btn-delete">حذف</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="queue-waiting-empty">
                            <p>لا توجد تذاكر في الانتظار</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

    </div>


    @if ($currentTicket ?? false)
        <div id="transferModal" class="transfer-modal">
            <div class="transfer-modal-content">
                <h3>تحويل التذكرة {{ $currentTicket->ticket_number }}</h3>

                <select id="transferServiceSelect" class="transfer-select">
                    <option value="">نفس الخدمة</option>
                    @foreach ($allServices as $srv)
                        @if ($currentTicket->service->name != $srv->name)
                            <option value="{{ $srv->code }}">{{ $srv->name }} ({{ $srv->code }})</option>
                        @endif
                    @endforeach
                </select>

                <form id="transferForm" action="{{ route('queue.transfer', $currentTicket) }}" method="POST">
                    @csrf
                    <input type="hidden" id="transferServiceCode" name="service_code">
                </form>

                <div class="transfer-actions">
                    <button onclick="confirmTransfer()" class="queue-btn queue-btn-save">تحويل</button>
                    <button onclick="closeTransferModal()" class="queue-btn queue-btn-cancel">إلغاء</button>
                </div>
            </div>
        </div>
    @endif
    <script>
        function openTransferModal() {
            document.getElementById('transferModal').style.display = 'flex';
        }

        function closeTransferModal() {
            document.getElementById('transferModal').style.display = 'none';
        }

        function confirmTransfer() {
            const serviceCode = document.getElementById('transferServiceSelect').value;
            document.getElementById('transferServiceCode').value = serviceCode;
            document.getElementById('transferForm').submit();
        }

        function formatTime(seconds) {
            const hrs = Math.floor(seconds / 3600);
            const mins = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;

            let time = '';
            if (hrs > 0) {
                time += `${String(hrs).padStart(2, '0')}:`;
            }
            time += `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;

            return time.replace(/[0-9]/g, d => ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'][d]);
        }

        const timerEl = document.getElementById('serviceTimer');
        if (timerEl) {
            const timerCard = document.querySelector('.queue-timer');
            const startTime = parseInt(timerCard.dataset.servedAt);

            function updateTimer() {
                const now = Math.floor(Date.now() / 1000);
                const elapsed = now - startTime;
                timerEl.textContent = formatTime(elapsed);
            }

            updateTimer();
            setInterval(updateTimer, 1000);
        }
    </script>
</x-app>
