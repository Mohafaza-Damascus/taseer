<x-app title="إنشاء حساب" :vite="['resources/css/admin/users/register.css']">
    <div class="create-page">

        <div class="create-header">
            <div class="create-header-info">
                <h1>إنشاء حساب</h1>
            </div>
            <a href="{{ route('admin.users.index') }}" class="create-back">رجوع</a>
        </div>

        <form action="{{ route('admin.users.register') }}" method="POST" class="create-form">
            @csrf

            <div class="create-card">
                <div class="form-group">
                    <label class="form-label">اسم المستخدم</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-input" placeholder="اختر اسم مستخدم" autofocus maxlength="255">
                    @error('username')
                        <span class="create-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">كلمة المرور</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-input" placeholder="٨ أحرف على الأقل" maxlength="255">
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                            <img src="{{ Vite::asset('resources/images/eye-off.svg') }}" class="eye-icon" alt="إظهار">
                        </button>
                    </div>
                    @error('password')
                        <span class="create-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">تأكيد كلمة المرور</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="أعد كتابة كلمة المرور" maxlength="255">
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                            <img src="{{ Vite::asset('resources/images/eye-off.svg') }}" class="eye-icon" alt="إظهار">
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">نوع الحساب</label>
                    <div class="role-cards">
                        <label class="role-card {{ old('role') == 'reception' ? 'selected' : '' }}">
                            <input type="radio" name="role" value="reception" {{ old('role') == 'reception' ? 'checked' : '' }}>
                            <div class="role-card-left">
                                <div>
                                    <span class="role-card-title">موظف استقبال</span>
                                    <span class="role-card-desc">إصدار التذاكر</span>
                                </div>
                            </div>
                            <img src="{{ Vite::asset('resources/images/seal-check.svg') }}" class="role-card-radio">
                        </label>
                        <label class="role-card {{ old('role') == 'agent' ? 'selected' : '' }}">
                            <input type="radio" name="role" value="agent" {{ old('role') == 'agent' ? 'checked' : '' }}>
                            <div class="role-card-left">
                                <div>
                                    <span class="role-card-title">موظف خدمة</span>
                                    <span class="role-card-desc">استدعاء الأدوار</span>
                                </div>
                            </div>
                            <img src="{{ Vite::asset('resources/images/seal-check.svg') }}" class="role-card-radio">
                        </label>
                    </div>
                    @error('role')<span class="create-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="create-actions">
                <button type="submit" class="create-btn create-btn-save">إنشاء حساب</button>
                <a href="{{ route('admin.users.index') }}" class="create-btn create-btn-cancel">إلغاء</a>
            </div>

        </form>

    </div>

    <script>
        document.querySelectorAll('.role-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.role-card').forEach(c => {
                    c.classList.remove('selected');
                    const radioImg = c.querySelector('.role-card-radio');
                    radioImg.src = "{{ Vite::asset('resources/images/seal-check.svg') }}";
                });
                this.classList.add('selected');
                this.querySelector('input').checked = true;
                const radioImg = this.querySelector('.role-card-radio');
                radioImg.src = "{{ Vite::asset('resources/images/seal-check-pineal-700.svg') }}";
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const selectedCard = document.querySelector('.role-card.selected');
            if (selectedCard) {
                const radioImg = selectedCard.querySelector('.role-card-radio');
                radioImg.src = "{{ Vite::asset('resources/images/seal-check-pineal-700.svg') }}";
            }
        });

        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const img = btn.querySelector('.eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                img.src = "{{ Vite::asset('resources/images/eye.svg') }}";
                img.alt = 'إخفاء';
            } else {
                input.type = 'password';
                img.src = "{{ Vite::asset('resources/images/eye-off.svg') }}";
                img.alt = 'إظهار';
            }
        }
    </script>
</x-app>
