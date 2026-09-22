<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إنشاء جهة واردة</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/incoming_entities/edit.css')
</head>

<body>

    <div class="container">

        <section class="header-card">

            <h1>
                إنشاء جهة واردة
            </h1>

            <a href="{{ route('incoming_entities.index') }}" class="btn-go-back">
                رجوع
            </a>

        </section>


        <form action="{{ route('incoming_entities.store') }}" method="POST" class="form-card">

            @csrf


            <div class="form-group">

                <label for="name">
                    الاسم
                </label>

                <input type="text" id="name" name="name" value="{{ old('name') }}" @class(['input-error' => $errors->has('name')])>

                @error('name')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <div class="form-group">

                <label for="notes">
                    ملاحظات
                </label>

                <input type="text" id="notes" name="notes" value="{{ old('notes') }}" @class(['input-error' => $errors->has('notes')])>

                @error('notes')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>



            <div class="form-actions">

                <button type="submit" class="btn-save">
                    حفظ
                </button>

                <a href="{{ route('incoming_entities.index') }}" class="btn-cancel">
                    إلغاء
                </a>

            </div>

        </form>

    </div>

</body>

</html>
