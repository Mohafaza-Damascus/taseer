<x-app title="المستخدمين" :vite="['resources/css/admin/users/index.css']">
    <div class="users-page">

        <div class="users-header">
            <h1>المستخدمين</h1>
            <div class="users-header-actions">
                <a href="{{ route('admin.users.register') }}" class="users-add-btn">إضافة حساب</a>
                <a href="{{ route('admin.dashboard') }}" class="users-back">رجوع</a>
            </div>
        </div>

        <div class="users-grid">
            @forelse($users as $user)
                <div class="user-card">

                    <div class="user-card-top">
                        <div class="user-info">
                            <span class="user-name">{{ $user->username }}</span>
                            <span class="user-role">
                                @if ($user->isAdmin())
                                    مدير النظام
                                @elseif($user->isReception())
                                    موظف استقبال
                                @else
                                    موظف خدمة
                                @endif
                            </span>
                        </div>

                        @if ($user->isAgent() || $user->isAdmin())
                            <a href="{{ route('admin.users.show', $user) }}" class="user-details-btn">
                                <span class="btn-label">تفاصيل</span>
                            </a>
                        @endif
                    </div>

                    <div class="user-card-actions">
                        <a href="{{ route('admin.users.edit', $user) }}" class="user-btn user-btn-edit">تعديل</a>
                        @if (!$user->isAdmin())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                onsubmit="return confirm('حذف {{ $user->username }}؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="user-btn user-btn-delete">حذف</button>
                            </form>
                        @endif
                    </div>

                </div>
            @empty
                <div class="users-empty">
                    <p>لا يوجد مستخدمين</p>
                </div>
            @endforelse
        </div>

    </div>
</x-app>
