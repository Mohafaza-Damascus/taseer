<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الدور - {{ $role->name }}</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/admin/roles/show.css')
</head>
<body>
    <div class="container">
        <section class="header-card">
            <h1>تفاصيل الدور</h1>
            <a href="{{ route('admin.roles.index') }}" class="btn-go-back">رجوع</a>
        </section>

        <div class="form-card">
            <div class="info-list">
                <div class="info-row">
                    <span class="info-label">الاسم</span>
                    <span class="info-value">{{ $role->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">المُعرّف (Slug)</span>
                    <span class="info-value">{{ $role->slug }}</span>
                </div>
            </div>

            <div>
                <span class="section-title">الصلاحيات ({{ $role->permissions->count() }})</span>
                <div class="chip-list">
                    @forelse($role->permissions as $permission)
                        <span class="chip">{{ $permission->name }}</span>
                    @empty
                        <span class="chip is-muted">لا يوجد صلاحيات</span>
                    @endforelse
                </div>
            </div>

            <div>
                <span class="section-title">المستخدمون بهذا الدور ({{ $role->users->count() }})</span>
                <div class="chip-list">
                    @forelse($role->users as $user)
                        <span class="chip is-muted">{{ $user->username }}</span>
                    @empty
                        <span class="chip is-muted">لا يوجد مستخدمون</span>
                    @endforelse
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.roles.edit', $role) }}" class="btn-primary">تعديل</a>

                <form action="{{ route('admin.roles.destroy', $role) }}"
                      method="POST"
                      onsubmit="return confirm('هل أنت متأكد من حذف الدور؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
