<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إنشاء متعهد</title>
    <style></style>
    @vite('resources/css/variables.css')
    @vite('resources/css/admin/contractors/create.css')
</head>

<body>

    <div class="container">

        <section class="header-card">

            <h1>
                إنشاء متعهد
            </h1>

            <a href="{{ route('contractors.index') }}" class="btn-go-back">
                رجوع
            </a>

        </section>


        <form action="{{ route('contractors.store') }}" method="POST" class="form-card">

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

                <label for="phone">
                    رقم الهاتف
                </label>

                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" @class(['input-error' => $errors->has('phone')])>

                @error('phone')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>
            <div class="form-group">

                <label for="national_number">
                    الرقم الوطني
                </label>

                <input type="text" id="national_number" name="national_number" value="{{ old('national_number') }}" @class(['input-error' => $errors->has('national_number')])>

                @error('national_number')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>
            <div class="form-group">

                <label for="company_name">
                    اسم الشركة
                </label>

                <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" @class(['input-error' => $errors->has('company_name')])>

                @error('company_name')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>



            <div class="form-actions">

                <button type="submit" class="btn-save">
                    حفظ
                </button>

                <a href="{{ route('contractors.index') }}" class="btn-cancel">
                    إلغاء
                </a>

            </div>

        </form>

    </div>

</body>

</html>
