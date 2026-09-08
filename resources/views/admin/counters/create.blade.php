<x-app title="إضافة نافذة" :vite="['resources/css/admin/counters/create.css']">
    <div class="create-page">

        <div class="create-header">
            <div class="create-header-info">
                <h1>إضافة نافذة</h1>
            </div>
            <a href="{{ route('admin.counters.index') }}" class="create-back">رجوع</a>
        </div>

        <form action="{{ route('admin.counters.store') }}" method="POST" class="create-form">
            @csrf

            <div class="create-card">
                <div class="form-group">
                    <label class="form-label">رقم النافذة</label>
                    <input type="number" name="id" min="1" value="{{ old('id') }}" class="form-input" placeholder="1">
                    @error('id')
                        <span class="create-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">عنوان IP</label>
                    <input type="text" name="ip_address" value="{{ old('ip_address') }}" class="form-input text-ltr" placeholder="192.168.1.10">
                    @error('ip_address')
                        <span class="create-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group-checkbox">
                    <label class="create-counter-item active" id="toggleBtn">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="create-checkbox" checked hidden>
                        <span class="create-counter-name">مفعل</span>
                    </label>
                    @error('is_active')
                        <span class="create-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="create-actions">
                <button type="submit" class="create-btn create-btn-save">إضافة النافذة</button>
                <a href="{{ route('admin.counters.index') }}" class="create-btn create-btn-cancel">إلغاء</a>
            </div>

        </form>

    </div>

    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const checkbox = toggleBtn.querySelector('.create-checkbox');
        const label = toggleBtn.querySelector('.create-counter-name');

        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const isChecked = !checkbox.checked;
            checkbox.checked = isChecked;

            if (isChecked) {
                toggleBtn.classList.add('active');
                label.textContent = 'مفعل';
            } else {
                toggleBtn.classList.remove('active');
                label.textContent = 'معطل';
            }
        });
    </script>
</x-app>
