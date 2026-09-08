<x-app title="الإعدادات" :vite="['resources/css/admin/settings/index.css']">

    <div class="st-page">

        {{-- ===== الهيدر ===== --}}
        <header class="st-header">
            <div class="st-header-text">
                <h1>الإعدادات</h1>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="st-back">
                لوحة التحكم
            </a>
        </header>

        {{-- ===== كارد واحدة: كل الإعدادات ===== --}}
        <section class="st-card">

            {{-- --- بلوك: رفع إعلان --- --}}
            <div class="st-block">
                <div class="st-block-head">
                    <h2>رفع إعلان جديد</h2>
                </div>

                <form action="{{ route('admin.settings.ad.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm" class="st-upload-form">
                    @csrf
                    <input type="file" name="ad_image" id="fileInput" accept="image/jpeg,image/png,image/webp" hidden required>

                    <div class="st-drop" id="dropZone">
                        {{-- الحالة الفارغة (label لفتح المتصفّح) --}}
                        <label class="st-drop-empty" id="dropEmpty" for="fileInput">
                            <span class="st-drop-badge">
                                <img src="{{ Vite::asset('resources/images/corner-out-pineal-700.svg') }}" alt="">
                            </span>
                            <p class="st-drop-title">اسحب صورة الإعلان هنا</p>
                            <p class="st-drop-hint">أو <span class="st-link">تصفّح جهازك</span></p>
                            <p class="st-drop-formats">JPG, JPEG, PNG, WebP — حتى ٥ ميغابايت</p>
                        </label>

                        {{-- الحالة بعد الاختيار --}}
                        <div class="st-drop-filled" id="dropFilled" style="display: none;">
                            <div class="st-preview"><img id="previewImg" src="" alt="معاينة"></div>
                            <div class="st-preview-info">
                                <span class="st-file-name" id="fileName"></span>
                                <button type="button" class="st-change" id="changeBtn">تغيير الصورة</button>
                            </div>
                        </div>
                    </div>

                    <div class="st-upload-footer" id="uploadFooter" style="display: none;">
                        <div class="st-field">
                            <label>مدة العرض</label>
                            <div class="st-stepper">
                                <button type="button" class="st-step" data-step="-1" tabindex="-1">−</button>
                                <input type="number" name="duration" id="durationInput" value="10" min="1" max="300">
                                <span class="st-step-unit">ث</span>
                                <button type="button" class="st-step" data-step="1" tabindex="-1">+</button>
                            </div>
                        </div>
                        <button type="submit" class="st-btn st-btn-primary">رفع الإعلان</button>
                    </div>

                    @error('ad_image')<span class="st-error">{{ $message }}</span>@enderror
                    @error('duration')<span class="st-error">{{ $message }}</span>@enderror
                </form>
            </div>

            <div class="st-divider"></div>

            {{-- --- بلوك: إعلانات الشاشة العامة --- --}}
            <div class="st-block">
                <div class="st-block-head">
                    <h2>إعلانات الشاشة العامة</h2>
                    <span class="st-count">{{ arabic_numbers($ads->count()) }}</span>
                </div>

                @if ($ads->isEmpty())
                    <div class="st-empty">
                        <span class="st-empty-badge">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>
                            </svg>
                        </span>
                        <h3>لا توجد إعلانات بعد</h3>
                        <p>ارفع أول إعلان ليظهر على الشاشة العامة</p>
                    </div>
                @else
                    <div class="st-grid" id="adsList">
                        @foreach ($ads as $ad)
                            <article class="st-ad" draggable="true" data-id="{{ $ad->id }}">
                                <span class="st-ad-order">{{ arabic_numbers($loop->iteration) }}</span>

                                <div class="st-ad-thumb">
                                    <img src="{{ asset('storage/' . $ad->image_path) }}" alt="إعلان">
                                    <span class="st-ad-duration">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 14"/>
                                        </svg>
                                        {{ arabic_numbers($ad->duration) }} ث
                                    </span>
                                </div>

                                <div class="st-ad-bar">
                                    <span class="st-ad-drag" title="اسحب لإعادة الترتيب">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="9" cy="6" r="1.6"/><circle cx="9" cy="12" r="1.6"/><circle cx="9" cy="18" r="1.6"/><circle cx="15" cy="6" r="1.6"/><circle cx="15" cy="12" r="1.6"/><circle cx="15" cy="18" r="1.6"/></svg>
                                    </span>
                                    <div class="st-ad-actions">
                                        <button type="button" class="st-icon st-icon-edit" onclick="adEdit(this)" title="تعديل المدة">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.settings.ad.delete', $ad) }}" method="POST" onsubmit="return confirm('حذف هذا الإعلان؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="st-icon st-icon-del" title="حذف">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- لوحة تعديل المدة --}}
                                <div class="st-ad-edit" style="display: none;">
                                    <form action="{{ route('admin.settings.ad.update', $ad) }}" method="POST">
                                        @csrf @method('PUT')
                                        <label>مدة العرض</label>
                                        <div class="st-stepper">
                                            <button type="button" class="st-step" data-step="-1" tabindex="-1">−</button>
                                            <input type="number" name="duration" value="{{ $ad->duration }}" min="1" max="300">
                                            <span class="st-step-unit">ث</span>
                                            <button type="button" class="st-step" data-step="1" tabindex="-1">+</button>
                                        </div>
                                        <div class="st-ad-edit-actions">
                                            <button type="submit" class="st-btn-mini st-btn-primary">حفظ</button>
                                            <button type="button" class="st-btn-mini st-btn-ghost" onclick="adEdit(this)">إلغاء</button>
                                        </div>
                                    </form>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    {{-- شريط حفظ الترتيب (يظهر عند تغيير الترتيب — يحفظ بدون إعادة تحميل) --}}
                    <div class="st-savebar" id="saveBar" style="display: none;">
                        <span class="st-savebar-text">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 9v4"/><path d="M12 17h.01"/><circle cx="12" cy="12" r="10"/>
                            </svg>
                            <span id="saveBarLabel">لديك تغييرات في الترتيب لم تُحفظ</span>
                        </span>
                        <div class="st-savebar-actions">
                            <button type="button" class="st-btn-mini st-btn-ghost" id="undoOrderBtn">تراجع</button>
                            <button type="button" class="st-btn-mini st-btn-primary" id="saveOrderBtn"
                                    data-url="{{ route('admin.settings.ad.reorder') }}">حفظ الترتيب</button>
                        </div>
                    </div>
                @endif
            </div>

        </section>
    </div>

    <script>
        (function () {
            const fileInput    = document.getElementById('fileInput');
            const dropZone     = document.getElementById('dropZone');
            const dropEmpty    = document.getElementById('dropEmpty');
            const dropFilled   = document.getElementById('dropFilled');
            const previewImg   = document.getElementById('previewImg');
            const fileName     = document.getElementById('fileName');
            const uploadFooter = document.getElementById('uploadFooter');

            // ===== معاينة الصورة =====
            function showFile(file) {
                if (!file || !file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = e => { previewImg.src = e.target.result; };
                reader.readAsDataURL(file);
                fileName.textContent = file.name;
                dropZone.classList.add('is-filled');
                dropEmpty.style.display    = 'none';
                dropFilled.style.display   = 'flex';
                uploadFooter.style.display = 'flex';
            }

            if (fileInput) {
                fileInput.addEventListener('change', () => {
                    if (fileInput.files && fileInput.files[0]) showFile(fileInput.files[0]);
                });
            }

            const changeBtn = document.getElementById('changeBtn');
            if (changeBtn) changeBtn.addEventListener('click', () => fileInput.click());

            // ===== سحب وإفلات ملف =====
            if (dropZone) {
                ['dragenter', 'dragover'].forEach(ev =>
                    dropZone.addEventListener(ev, e => { e.preventDefault(); dropZone.classList.add('is-dragover'); })
                );
                dropZone.addEventListener('dragleave', e => {
                    if (!dropZone.contains(e.relatedTarget)) dropZone.classList.remove('is-dragover');
                });
                dropZone.addEventListener('drop', e => {
                    e.preventDefault();
                    dropZone.classList.remove('is-dragover');
                    const file = e.dataTransfer.files && e.dataTransfer.files[0];
                    if (!file) return;
                    try { const dt = new DataTransfer(); dt.items.add(file); fileInput.files = dt.files; } catch (err) {}
                    showFile(file);
                });
            }

            // ===== ستيبر المدة (يشمل كل الستيبرات) =====
            document.addEventListener('click', e => {
                const step = e.target.closest('.st-step');
                if (!step) return;
                const input = step.parentElement.querySelector('input[type="number"]');
                if (!input) return;
                const min = parseInt(input.min, 10) || 1;
                const max = parseInt(input.max, 10) || 300;
                let v = parseInt(input.value, 10);
                if (isNaN(v)) v = min;
                v += parseInt(step.dataset.step, 10);
                input.value = Math.max(min, Math.min(max, v));
            });

            // ===== تعديل سريع =====
            window.adEdit = function (btn) {
                const card = btn.closest('.st-ad');
                const panel = card.querySelector('.st-ad-edit');
                const isOpen = panel.style.display === 'flex';
                document.querySelectorAll('.st-ad-edit').forEach(p => p.style.display = 'none');
                document.querySelectorAll('.st-ad.is-editing').forEach(c => c.classList.remove('is-editing'));
                if (!isOpen) {
                    panel.style.display = 'flex';
                    card.classList.add('is-editing');
                }
            };

            // ===== إعادة الترتيب (سحب حرّ بدون إعادة تحميل + حفظ يدوي) =====
            const list = document.getElementById('adsList');
            if (list) {
                const saveBar = document.getElementById('saveBar');
                const saveBtn = document.getElementById('saveOrderBtn');
                const undoBtn = document.getElementById('undoOrderBtn');
                const saveLbl = document.getElementById('saveBarLabel');
                let dragged = null;
                let originalOrder = currentIds();

                function currentIds() {
                    return [...list.querySelectorAll('.st-ad')].map(c => c.dataset.id);
                }
                function isDirty() {
                    const c = currentIds();
                    return c.length !== originalOrder.length || c.some((id, i) => id !== originalOrder[i]);
                }
                function renumber() {
                    list.querySelectorAll('.st-ad').forEach((c, i) => {
                        const b = c.querySelector('.st-ad-order');
                        if (b) b.textContent = i + 1;
                    });
                }
                function refreshBar() {
                    saveBar.style.display = isDirty() ? 'flex' : 'none';
                }

                list.addEventListener('dragstart', e => {
                    dragged = e.target.closest('.st-ad');
                    if (dragged) setTimeout(() => dragged.classList.add('is-dragging'), 0);
                });

                list.addEventListener('dragend', () => {
                    if (!dragged) return;
                    dragged.classList.remove('is-dragging');
                    dragged = null;
                    renumber();
                    refreshBar();
                });

                list.addEventListener('dragover', e => {
                    e.preventDefault();
                    if (!dragged) return;
                    const after = getAfter(e.clientX, e.clientY);
                    if (after == null) list.appendChild(dragged);
                    else list.insertBefore(dragged, after);
                });

                function getAfter(x, y) {
                    const els = [...list.querySelectorAll('.st-ad:not(.is-dragging)')];
                    let closest = { dist: Infinity, el: null };
                    for (const el of els) {
                        const b = el.getBoundingClientRect();
                        const cx = b.left + b.width / 2, cy = b.top + b.height / 2;
                        const before = y < cy - b.height / 2 || (Math.abs(y - cy) <= b.height / 2 && x > cx);
                        if (before) {
                            const dist = Math.hypot(x - cx, y - cy);
                            if (dist < closest.dist) closest = { dist, el };
                        }
                    }
                    return closest.el;
                }

                undoBtn.addEventListener('click', () => {
                    originalOrder.forEach(id => {
                        const el = list.querySelector('.st-ad[data-id="' + id + '"]');
                        if (el) list.appendChild(el);
                    });
                    renumber();
                    refreshBar();
                });

                saveBtn.addEventListener('click', () => {
                    const ids = currentIds();
                    const token = document.querySelector('meta[name="csrf-token"]').content;
                    saveBtn.disabled = true;
                    saveBtn.textContent = 'جارٍ الحفظ…';
                    fetch(saveBtn.dataset.url, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                        body: new URLSearchParams({ order: JSON.stringify(ids) })
                    }).then(r => {
                        if (!r.ok && r.status !== 0) throw new Error('bad status');
                        originalOrder = ids;
                        saveLbl.textContent = 'تم حفظ الترتيب';
                        saveBtn.textContent = 'حفظ الترتيب';
                        saveBtn.disabled = false;
                        setTimeout(() => {
                            saveLbl.textContent = 'لديك تغييرات في الترتيب لم تُحفظ';
                            refreshBar();
                        }, 900);
                    }).catch(() => {
                        saveBtn.textContent = 'حفظ الترتيب';
                        saveBtn.disabled = false;
                        alert('تعذّر حفظ الترتيب، حاول مجدداً.');
                    });
                });
            }
        })();
    </script>

</x-app>
