<x-app title="تعديل مستخدم" :vite="['resources/css/admin/users/edit.css']">
    <div class="edit-page">

        <div class="edit-header">
            <div class="edit-header-info">
                <h1>{{ $user->username }}</h1>
            </div>
            <a href="{{ route('admin.users.index') }}" class="edit-back">رجوع</a>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="edit-form">
            @csrf @method('PUT')

            @if ($user->isAgent() || $user->isAdmin())
                <div class="edit-card">
                    <h2 class="edit-card-title">النافذة</h2>
                    <select name="counter_id" class="edit-select">
                        <option value="">بدون نافذة</option>
                        @foreach ($counters as $c)
                            <option value="{{ $c->id }}" {{ old('counter_id', $user->counter_id) == $c->id ? 'selected' : '' }}>
                                نافذة {{ arabic_numbers($c->id) }}
                            </option>
                        @endforeach
                    </select>
                    @error('counter_id')
                        <span class="edit-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="edit-card">
                    <h2 class="edit-card-title">الخدمات</h2>
                    <div class="edit-services">
                        @foreach ($services as $s)
                            <label class="edit-service-item">
                                <input
                                    type="checkbox"
                                    name="services[]"
                                    value="{{ $s->code }}"
                                    class="edit-checkbox"
                                    {{ in_array($s->code, old('services', $user->services->pluck('code')->toArray())) ? 'checked' : '' }}
                                hidden>
                                <span class="edit-service-label">
                                    <span class="edit-service-name">{{ $s->name }}</span>
                                    <span class="edit-service-code">{{ $s->code }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('services')
                        <span class="edit-error">{{ $message }}</span>
                    @enderror
                    @error('services.*')
                        <span class="edit-error">{{ $message }}</span>
                    @enderror
                </div>
            @else
                <div class="edit-card">
                    <p class="edit-notice">موظف الاستقبال لا يمكن تعيين نافذة أو خدمات له.</p>
                </div>
            @endif


            <div class="edit-actions">
                <button type="submit" class="edit-btn edit-btn-save">حفظ التعديلات</button>
                <a href="{{ route('admin.users.index') }}" class="edit-btn edit-btn-cancel">إلغاء</a>
            </div>

        </form>

    </div>
</x-app>
