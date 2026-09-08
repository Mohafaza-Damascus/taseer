<x-app title="إضافة خدمة" :vite="['resources/css/admin/services/create.css']">
    <div class="create-page">

        <div class="create-header">
            <div class="create-header-info">
                <h1>إضافة خدمة</h1>
            </div>
            <a href="{{ route('admin.services.index') }}" class="create-back">رجوع</a>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" class="create-form">
            @csrf

            <div class="create-card">
                <div class="form-group">
                    <label class="form-label">اسم الخدمة</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="سجل عدلي">
                    @error('name')
                        <span class="create-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">رمز الخدمة</label>
                    <input type="text" name="code" value="{{ old('code') }}" class="form-input" maxlength="1" placeholder="حرف واحد A-Z">
                    @error('code')
                        <span class="create-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group-checkbox">
                    <label class="create-service-item active" id="toggleBtn">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="create-checkbox" checked hidden>
                        <span class="create-service-name">مفعلة</span>
                    </label>
                    @error('is_active')
                        <span class="create-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="create-actions">
                <button type="submit" class="create-btn create-btn-save">إضافة الخدمة</button>
                <a href="{{ route('admin.services.index') }}" class="create-btn create-btn-cancel">إلغاء</a>
            </div>

        </form>

    </div>

    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const checkbox = toggleBtn.querySelector('.create-checkbox');
        const label = toggleBtn.querySelector('.create-service-name');

        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const isChecked = !checkbox.checked;
            checkbox.checked = isChecked;

            if (isChecked) {
                toggleBtn.classList.add('active');
                label.textContent = 'مفعلة';
            } else {
                toggleBtn.classList.remove('active');
                label.textContent = 'معطلة';
            }
        });
    </script>
</x-app>
