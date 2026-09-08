<x-app title="الخدمات" :vite="['resources/css/services/index.css']">

    <div class="services-screen">
        <div class="services-header">
            <h1>الخدمات</h1>
            <p>اختر الخدمة المطلوبة لإصدار تذكرة</p>
        </div>

        <div class="services-grid">
            @forelse($services as $service)
                <button class="service-card-btn" onclick="issueTicket('{{ $service->code }}', '{{ $service->name }}')">
                    <span class="service-card-code">{{ $service->code }}</span>
                    <span class="service-card-name">{{ $service->name }}</span>
                </button>
            @empty
                <div class="services-empty">
                    <p>لا توجد خدمات متاحة حالياً</p>
                </div>
            @endforelse
        </div>
    </div>
    <div class="toast-overlay"></div>

    <script>
        async function issueTicket(serviceCode, serviceName) {
            try {
                const res = await fetch('{{ route('services.issue') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ service_code: serviceCode }),
                });

                const data = await res.json();


                if (data.success) {
                    showToast('success', data.message);
                } else {
                    showToast('error', data.message);
                }

                console.log(data);
            } catch (err) {
                showToast('error', 'خطأ في الاتصال');
            }
        }

        function showToast(type, message) {
            const toast = document.querySelector('.toast-overlay');
            if (!toast) return;

            if (type == "success") {
                toast.innerHTML = `
                    <div class="toast toast-${type}">
                        <img src="{{ Vite::asset('resources/images/check-circle-golden-wheat-100.svg') }}"
                            class="toast-icon" alt="">
                        <span>${ message }</span>
                        <button onclick="this.closest('.toast').remove()">
                            <img src="{{ Vite::asset('resources/images/x.svg') }}" alt="إغلاق"
                                class="toast-close-icon">
                        </button>
                    </div>
                `;
            }
            else
            {
                toast.innerHTML = `
                    <div class="toast toast-${type}">
                        <img src="{{ Vite::asset('resources/images/x-circle-golden-wheat-100.svg') }}"
                            class="toast-icon" alt="">
                        <span>${ message }</span>
                        <button onclick="this.closest('.toast').remove()">
                            <img src="{{ Vite::asset('resources/images/x.svg') }}" alt="إغلاق"
                                class="toast-close-icon">
                        </button>
                    </div>
                `;
            }
        }

        let isPlaying = false;
        const queue = [];

        function getNumberFiles(num) {
            if (num <= 19) return [`/audio/${num}.mp3`];
            const files = [];
            if (num >= 100) {
                const h = Math.floor(num / 100) * 100;
                files.push(`/audio/${h}.mp3`);
                num %= 100;
                if (num > 0) files.push('/audio/and.mp3');
            }
            if (num > 0) {
                if (num <= 19) {
                    files.push(`/audio/${num}.mp3`);
                } else {
                    const ones = num % 10;
                    const tens = Math.floor(num / 10) * 10;
                    if (ones > 0) {
                        files.push(`/audio/${ones}.mp3`);
                        files.push('/audio/and.mp3');
                    }
                    files.push(`/audio/${tens}.mp3`);
                }
            }
            return files;
        }

        function buildAudioFiles(ticketNumber, counterId) {
            const parts = ticketNumber.split('-');
            const letter = parts[0].toUpperCase();
            const ticketNum = parseInt(parts[1]);
            return [
                '/audio/ticket_num.mp3',
                `/audio/${letter}.mp3`,
                ...getNumberFiles(ticketNum),
                '/audio/please_go.mp3',
                ...getNumberFiles(counterId),
            ];
        }

        function playFiles(files) {
            if (files.length === 0) {
                isPlaying = false;
                processQueue();
                return;
            }
            isPlaying = true;
            const file = files.shift();
            const audio = new Audio(file);
            audio.play().catch(() => {});
            audio.onended = () => playFiles(files);
        }

        function processQueue() {
            if (queue.length > 0 && !isPlaying) {
                playFiles(queue.shift());
            }
        }

        window.addEventListener('load', () => {
            if (window.Echo) {
                window.Echo.channel('ticket-calls')
                    .listen('.ticket.called', (data) => {
                        queue.push(buildAudioFiles(data.ticket_number, data.counter_id));
                        processQueue();
                    });
            }
        });
    </script>

</x-app>
