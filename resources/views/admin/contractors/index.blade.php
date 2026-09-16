<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>الأدوار</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/users/index.css')
</head>

<body>

<div class="container">

    <section class="header-card">

        <h1>
            الأدوار
        </h1>

        <a
            href="{{ route('dashboard') }}"
            class="btn-go-back"
        >
            رجوع
        </a>

    </section>


    @if ($roles->isEmpty())

        <div class="no-results">
            <p>
                لا يوجد أدوار
            </p>
        </div>

    @else

        <div class="cards-grid">

            @foreach ($roles as $role)

                <div class="card">

                    <span class="card-title">
                        {{ $role->name }}
                    </span>

                    <span class="card-subtitle">
                        {{ $role->slug }}
                    </span>

                    <div class="card-footer">

                        <a
                            href="{{ route('roles.show', $role) }}"
                            class="btn-details"
                        >
                            عرض التفاصيل
                        </a>

                    </div>

                </div>

            @endforeach


            <a
                href="{{ route('roles.create') }}"
                class="add-card"
                title="إضافة رول جديد"
            >
                <span class="add-card-icon">
                    +
                </span>
            </a>

        </div>

    @endif


    @if ($roles->hasPages())

        {{ $roles->links() }}

    @endif

</div>

</body>
</html>