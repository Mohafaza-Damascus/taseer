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

            @foreach ($errors->all() as $error)
                <span class="form-error">
                    {{ $error }}
                </span>
            @endforeach

            <div class="form-actions">

                <a href="{{ route('incoming_entities.edit', $incomingEntity) }}" class="btn-edit">
                    تعديل
                </a>


                <form action="{{ route('incoming_entities.destroy', $incomingEntity) }}" method="POST"
                    onsubmit="return confirm('هل أنت متأكد من حذف الجهة الواردة؟');">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-delete">
                        حذف
                    </button>

                </form>
            </div>

        </div>

    </div>

</body>

</html>
