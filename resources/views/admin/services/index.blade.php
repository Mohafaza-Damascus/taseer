<x-app title="الخدمات" :vite="['resources/css/admin/services/index.css']">
    <div class="services-page">

        <div class="services-header">
            <h1>الخدمات</h1>
            <div class="services-header-actions">
                <a href="{{ route('admin.services.create') }}" class="services-btn-create">إضافة خدمة</a>
                <a href="{{ route('admin.dashboard') }}" class="services-back">رجوع</a>
            </div>
        </div>

        <div class="services-grid">
            @forelse($services as $service)
                <div class="service-card">

                    <div class="service-card-top">
                        <div class="service-info">
                            <span class="service-name">{{ $service->name }}</span>
                            <span class="service-code">{{ $service->code }}</span>
                        </div>
                    </div>

                    <div class="service-card-stats">
                        <div class="service-stat">
                            <span class="service-stat-lbl">الحالة</span>
                            <span class="service-stat-val {{ $service->is_active ? 'text-active' : 'text-inactive' }}">
                                {{ $service->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </div>
                    </div>

                    <div class="service-card-actions">
                        <a href="{{ route('admin.services.edit', $service) }}" class="service-btn service-btn-edit">تعديل</a>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                            onsubmit="return confirm('هل أنت متأكد من حذف الخدمة {{ $service->name }}؟')">
                            @csrf @method('DELETE')
                            <button type="submit" class="service-btn service-btn-delete">حذف</button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="services-empty">
                    <p>لا يوجد خدمات مضافة حالياً</p>
                </div>
            @endforelse
        </div>

    </div>
</x-app>
