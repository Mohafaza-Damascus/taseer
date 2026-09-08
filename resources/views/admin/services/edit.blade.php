<x-app title="تعديل خدمة" :vite="['resources/css/admin/services/edit.css']">
    <div class="edit-page">

        <div class="edit-header">
            <div class="edit-header-info">
                <h1>{{ $service->name }}</h1>
            </div>
            <a href="{{ route('admin.services.index') }}" class="edit-back">رجوع</a>
        </div>

        <form action="{{ route('admin.services.update', $service) }}" method="POST" class="edit-form">
            @csrf @method('PUT')

            <div class="edit-card">
                <div class="form-group">
                    <label class="form-label">اسم الخدمة</label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}" class="form-input">
                    @error('name')
                        <span class="edit-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">رمز الخدمة</label>
                    <input type="text" name="code" value="{{ old('code', $service->code) }}" class="form-input"
                        maxlength="1">
                    @error('code')
                        <span class="edit-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group-checkbox">
                    <label class="edit-service-item {{ old('is_active', $service->is_active) ? 'active' : '' }}"
                        id="toggleBtn">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="edit-checkbox"
                            {{ old('is_active', $service->is_active) ? 'checked' : '' }} hidden>
                        <span class="edit-service-name">
                            {{ old('is_active', $service->is_active) ? 'مفعلة' : 'معطلة' }}
                        </span>
                    </label>
                    @error('is_active')
                        <span class="edit-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="edit-actions">
                <button type="submit" class="edit-btn edit-btn-save">حفظ التعديلات</button>
                <a href="{{ route('admin.services.index') }}" class="edit-btn edit-btn-cancel">إلغاء</a>
            </div>

        </form>

    </div>
    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const checkbox = toggleBtn.querySelector('.edit-checkbox');
        const label = toggleBtn.querySelector('.edit-service-name');

        if (checkbox.checked) {
            toggleBtn.classList.add('active');
            label.textContent = 'مفعلة';
        } else {
            toggleBtn.classList.remove('active');
            label.textContent = 'معطلة';
        }

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
