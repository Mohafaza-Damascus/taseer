<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $user->username }}</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/admin/users/show.css')
</head>

<body>

    <div class="container">

        <section class="header-card">

            <h1>
                تفاصيل المستخدم
            </h1>

            <a href="{{ route('users.index') }}" class="btn-go-back">
                رجوع
            </a>

        </section>


        <div class="form-card">

            <div class="info-list">

                <div class="info-row">

                    <span class="info-label">
                        اسم المستخدم
                    </span>

                    <span class="info-value">
                        {{ $user->username }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        تاريخ الإنشاء
                    </span>

                    <span class="info-value">
                        {{ $user->created_at?->format('Y-m-d H:i') }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        الدور
                    </span>

                    <span class="info-value">

                        @if ($user->roles->isNotEmpty())

                            {{ $user->roles->pluck('name')->join('، ') }}

                        @else

                            لا يوجد دور

                        @endif

                    </span>

                </div>

            </div>


            <div>

                <span class="section-title">
                    الصلاحيات
                </span>


                <div class="chip-list">

                    @php
                        $permissions = $user->roles
                            ->flatMap(fn($role) => $role->permissions)
                            ->unique('id');
                    @endphp


                    @forelse ($permissions as $permission)

                        <span class="chip">
                            {{ $permission->name }}
                        </span>

                    @empty

                        <span class="chip">
                            لا يوجد صلاحيات
                        </span>

                    @endforelse

                </div>

            </div>


            @if(auth()->user()->hasPermission('users.manage'))
                <div class="form-actions">

                    <a href="{{ route('users.edit', $user) }}" class="btn-edit">
                        تعديل
                    </a>

                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                        onsubmit="return confirm('هل أنت متأكد من حذف المستخدم؟');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-delete">
                            حذف
                        </button>
                    </form>

                </div>
            @endif

        </div>

    </div>

</body>

</html>