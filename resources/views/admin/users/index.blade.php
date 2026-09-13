<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>المستخدمين</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/users/index.css')
</head>

<body>

    <div class="container">

        <section class="header-card">

            <h1>
                المستخدمين
            </h1>

            <a href="{{ route('dashboard') }}" class="btn-go-back">
                رجوع
            </a>

        </section>


        @if ($users->isEmpty())

            <div class="no-results">
                <p>
                    لا يوجد مستخدمين
                </p>
            </div>

        @else

            <div class="cards-grid">

                @foreach ($users as $user)

                    <div class="card">

                        <span class="card-title">
                            {{ $user->username }}
                        </span>

                        <span class="card-subtitle">

                            @if ($user->roles->isNotEmpty())

                                {{ $user->roles->pluck('name')->join('، ') }}

                            @else

                                بدون دور

                            @endif

                        </span>


                        <div class="card-footer">

                            <a href="{{ route('users.show', $user) }}" class="btn-details">
                                عرض التفاصيل
                            </a>

                        </div>

                    </div>

                @endforeach


                <a href="{{ route('users.create') }}" class="add-card" title="إضافة مستخدم جديد">
                    <span class="add-card-icon">
                        +
                    </span>
                </a>

            </div>

        @endif


        @if ($users->hasPages())

            {{ $users->links() }}

        @endif

    </div>

</body>

</html>