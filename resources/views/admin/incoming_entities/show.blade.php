<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $incomingEntity->name }}</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/incoming_entities/show.css')
</head>

<body>

    <div class="container">

        <section class="header-card">

            <h1>
                تفاصيل الجهة الواردة
            </h1>

            <a href="{{ route('incoming_entities.index') }}" class="btn-go-back">
                رجوع
            </a>

        </section>


        <div class="form-card">

            <div class="info-list">

                <div class="info-row">

                    <span class="info-label">
                        الاسم
                    </span>

                    <span class="info-value">
                        {{ $incomingEntity->name }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        ملاحظات
                    </span>

                    <span class="info-value">
                        {{ $incomingEntity->notes }}
                    </span>

                </div>

            </div>

            @if(session('error'))
                <span class="form-error">
                    {{ session('error') }}
                </span>
            @endif

            <div class="form-actions">

                @if(auth()->user()->hasPermission('incoming_entities.update'))
                    <a href="{{ route('incoming_entities.edit', $incomingEntity) }}" class="btn-edit">
                        تعديل
                    </a>
                @endif


                @if(auth()->user()->hasPermission('incoming_entities.delete'))
                    <form action="{{ route('incoming_entities.destroy', $incomingEntity) }}" method="POST"
                        onsubmit="return confirm('هل أنت متأكد من حذف الجهة الواردة؟');">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-delete">
                            حذف
                        </button>

                    </form>
                @endif

            </div>
        </div>

    </div>

</body>

</html>