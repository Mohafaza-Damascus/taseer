<x-app title="الشاشة العامة" :vite="['resources/css/counters/live.css']">

    <div class="live">
        <div class="live-top">
            <h1>مركز خدمة المواطن - بلدية اليرموك</h1>
            <span class="live-date" id="liveDate">٠٠/٠٠/٠٠٠٠</span>
            <span class="live-clock" id="clock">٠٠:٠٠</span>
        </div>

        <div class="live-main">
            <div class="live-list">
                <div class="live-list-head">
                    <span>النافذة</span>
                    <span>رقم التذكرة</span>
                    <span>الحالة</span>
                </div>
                <div class="live-list-body" id="liveGrid">
                    @php
                        $busyCounters = $counters->filter(fn($c) => $c['current_ticket']);
                    @endphp

                    @foreach ($busyCounters as $counter)
                        <div class="live-item" data-id="{{ $counter['counter_id'] }}">
                            <span class="live-item-counter">نافذة {{ arabic_numbers($counter['counter_id']) }}</span>
                            <span class="live-item-ticket">{{ $counter['current_ticket'] }}</span>
                            <span class="live-item-status status-serving">قيد الخدمة</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="live-ad" id="liveAdContainer">
                @if ($ads->isNotEmpty())
                    @php $firstAd = $ads->first(); @endphp
                    <img src="{{ asset('storage/' . $firstAd->image_path) }}" alt="إعلان" class="live-ad-img">
                @else
                    <div class="live-ad-text">
                        <p>مساحة إعلانية</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function arabic_numbers(num) {
            const d = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
            return String(num).replace(/[0-9]/g, x => d[x]);
        }

        function renderCounters(data) {
            const list = document.getElementById('liveGrid');
            const counters = Array.isArray(data) ? [...data] : [];
            const busy = counters
                .filter(c => c.current_ticket)
                .sort((a, b) => new Date(b.called_at) - new Date(a.called_at));

            let html = '';
            busy.forEach(c => {
                html += `
                    <div class="live-item" data-id="${c.counter_id}">
                        <span class="live-item-counter">نافذة ${arabic_numbers(c.counter_id)}</span>
                        <span class="live-item-ticket">${c.current_ticket}</span>
                        <span class="live-item-status status-serving">قيد الخدمة</span>
                    </div>`;
            });

            list.innerHTML = html;
        }

        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent =
                now.toLocaleTimeString('ar-SA', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
        }
        setInterval(updateClock, 1000);
        updateClock();


        function updateDate() {
            const now = new Date();
            document.getElementById('liveDate').textContent = now.toLocaleDateString('ar-SA', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            });
        }
        setInterval(updateDate, 60000);
        updateDate();

        let adsList = @json($ads->map(fn($ad) => ['image_url' => asset('storage/' . $ad->image_path), 'duration' => $ad->duration]));
        let currentAdIndex = 0;
        let adTimer = null;

        function showNextAd() {
            if (!adsList.length) return;
            const ad = adsList[currentAdIndex];
            const container = document.getElementById('liveAdContainer');

            // نحمّل الصورة الجديدة أولاً حتى الانتقال يكون ناعم بدون وميض
            const img = new Image();
            img.className = 'live-ad-img is-entering';
            img.alt = 'إعلان';

            const reveal = () => {
                // نشيل أي نص/placeholder
                container.querySelectorAll('.live-ad-text, .live-ad-placeholder').forEach(el => el.remove());
                const previous = Array.from(container.querySelectorAll('.live-ad-img'));
                container.appendChild(img);
                // نجبر إعادة الرسم ثم نبدأ الـfade
                requestAnimationFrame(() => requestAnimationFrame(() => img.classList.remove('is-entering')));
                // بعد انتهاء الـfade نحذف الصور القديمة
                setTimeout(() => previous.forEach(p => p.remove()), 900);
            };

            img.onload = reveal;
            img.onerror = reveal;
            img.src = ad.image_url;

            currentAdIndex = (currentAdIndex + 1) % adsList.length;
            adTimer = setTimeout(showNextAd, ad.duration * 1000);
        }

        if (adsList.length > 0) {
            showNextAd();
        }

        window.Echo.channel('ad-updates')
            .listen('.ad.screen.updated', (data) => {
                adsList = data.ads || [];
                if (adsList.length > 0) {
                    currentAdIndex = 0;
                    clearTimeout(adTimer);
                    showNextAd();
                } else {
                    document.getElementById('liveAdContainer').innerHTML =
                        '<div class="live-ad-placeholder"><p>مساحة إعلانية</p></div>';
                }
            });


        window.addEventListener('load', () => {
            if (window.Echo) {
                window.Echo.channel('screen-titckets-updates')
                    .listen('.ticket.screen.updated', (data) => {
                        renderCounters(data);
                    });
            }
        });
    </script>

</x-app>
