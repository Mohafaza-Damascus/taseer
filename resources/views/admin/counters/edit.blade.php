<x-app title="تعديل نافذة" :vite="['resources/css/admin/counters/edit.css']">
    <div class="edit-page">

        <div class="edit-header">
            <div class="edit-header-info">
                <h1>نافذة {{ $counter->id }}</h1>
            </div>
            <a href="{{ route('admin.counters.index') }}" class="edit-back">رجوع</a>
        </div>

        <form action="{{ route('admin.counters.update', $counter) }}" method="POST" class="edit-form">
            @csrf @method('PUT')

            <div class="edit-card">
                <div class="form-group">
                    <label class="form-label">رقم النافذة</label>
                    <input type="text" value="{{ $counter->id }}" class="form-input form-input-disabled" readonly disabled>
                </div>

                <div class="form-group">
                    <label class="form-label">عنوان IP</label>
                    <input type="text" name="ip_address" value="{{ old('ip_address', $counter->ip_address) }}" class="form-input text-ltr">
                    @error('ip_address')
                        <span class="edit-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group-checkbox">
                    <label class="edit-counter-item {{ old('is_active', $counter->is_active) ? 'active' : '' }}" id="toggleBtn">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="edit-checkbox"
                            {{ old('is_active', $counter->is_active) ? 'checked' : '' }} hidden>
                        <span class="edit-counter-name">
                            {{ old('is_active', $counter->is_active) ? 'مفعل' : 'معطل' }}
                        </span>
                    </label>
                    @error('is_active')
                        <span class="edit-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="edit-actions">
                <button type="submit" class="edit-btn edit-btn-save">حفظ التعديلات</button>
                <a href="{{ route('admin.counters.index') }}" class="edit-btn edit-btn-cancel">إلغاء</a>
            </div>

        </form>

    </div>

    <script>
        const toggleBtn = document.getElementById('toggleBtn');
        const checkbox = toggleBtn.querySelector('.edit-checkbox');
        const label = toggleBtn.querySelector('.edit-counter-name');

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
