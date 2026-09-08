<x-app title="النوافذ" :vite="['resources/css/admin/counters/index.css']">
    <div class="counters-page">

        <div class="counters-header">
            <h1>النوافذ</h1>
            <div class="counters-header-actions">
                <a href="{{ route('admin.counters.create') }}" class="counters-btn-create">إضافة نافذة</a>
                <a href="{{ route('admin.dashboard') }}" class="counters-back">رجوع</a>
            </div>
        </div>

        <div class="counters-grid">
            @forelse($counters as $counter)
                <div class="counter-card">

                    <div class="counter-card-top">
                        <div class="counter-info">
                            <span class="counter-name">نافذة {{ arabic_numbers($counter->id) }}</span>
                            <span class="counter-ip">{{ arabic_numbers($counter->ip_address) }}</span>
                        </div>
                    </div>

                    <div class="counter-card-stats">
                        <div class="counter-stat">
                            <span class="counter-stat-lbl">الحالة</span>
                            <span class="counter-stat-val {{ $counter->is_active ? 'text-active' : 'text-inactive' }}">
                                {{ $counter->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </div>
                    </div>

                    <div class="counter-card-actions">
                        <a href="{{ route('admin.counters.edit', $counter) }}" class="counter-btn counter-btn-edit">تعديل</a>
                        <form action="{{ route('admin.counters.destroy', $counter) }}" method="POST"
                            onsubmit="return confirm('هل أنت متأكد من حذف نافذة {{ $counter->id }}؟')">
                            @csrf @method('DELETE')
                            <button type="submit" class="counter-btn counter-btn-delete">حذف</button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="counters-empty">
                    <p>لا يوجد شبابيك مضافة حالياً</p>
                </div>
            @endforelse
        </div>

    </div>
</x-app>
