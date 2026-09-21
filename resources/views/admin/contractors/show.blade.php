<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $contractor->name }}</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/incoming_entities/show.css')
</head>

<body>

    <div class="container">

        <section class="header-card">

            <h1>
                تفاصيل المتعهد
            </h1>

            <a href="{{ route('contractors.index') }}" class="btn-go-back">
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
                        {{ $contractor->name }}
                    </span>

                </div>

                <div class="info-row">

                    <span class="info-label">
                        رقم الهاتف
                    </span>

                    <span class="info-value">
                        {{ $contractor->phone }}
                    </span>

                </div>

                <div class="info-row">

                    <span class="info-label">
                        الرقم الوطني
                    </span>

                    <span class="info-value">
                        {{ $contractor->national_number }}
                    </span>

                </div>

                <div class="info-row">

                    <span class="info-label">
                        اسم الشركة
                    </span>

                    <span class="info-value">
                        {{ $contractor->company_name }}
                    </span>

                </div>

            </div>

            @if($errors->has('error'))

                <span class="form-error">
                    {{ $errors->first('error') }}
                </span>

            @endif

            <div class="form-actions">

                @if(auth()->user()->hasPermission('contractors.update'))

                    <a href="{{ route('contractors.edit', $contractor) }}" class="btn-edit">
                        تعديل
                    </a>

                @endif

                @if(auth()->user()->hasPermission('contractors.delete'))

                    <form action="{{ route('contractors.destroy', $contractor) }}" method="POST"
                        onsubmit="return confirm('هل أنت متأكد من حذف المتعهد؟');">

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