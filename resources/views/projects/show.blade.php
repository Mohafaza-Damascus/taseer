<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $project->name }}</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/projects/show.css')

</head>

<body>

    <div class="container">

        <section class="page-header">

            <div class="header-main">

                <div class="header-titles">
                    <h1>{{ $project->name }}</h1>
                </div>

                <div class="header-actions">
                    <a href="{{ route('projects.edit', $project) }}" class="btn-edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                        </svg>
                        تعديل المشروع
                    </a>

                    <form method="POST" action="{{ route('projects.destroy', $project) }}"
                        onsubmit="return confirm('هل أنت متأكد من حذف المشروع؟');">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-delete">
                            حذف المشروع
                        </button>

                    </form>
                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- Project Information --}}
            {{-- ========================================================= --}}

            <section class="info-grid">

                {{-- Incoming Entity --}}
                <div class="info-card">

                    <h2 class="info-card-title">الجهة الواردة</h2>

                    <div class="info-item">
                        <label>الاسم : </label>
                        <span>{{ $project->incomingEntity?->name ?? 'غير محددة' }}</span>
                    </div>

                    <div class="info-item">
                        <label>ملاحظات : </label>
                        <span>{{ $project->incomingEntity?->notes ?? 'لا توجد ملاحظات' }}</span>
                    </div>

                </div>


                {{-- Contractor --}}
                <div class="info-card">

                    <h2 class="info-card-title">المقاول</h2>

                    <div class="info-item">
                        <label>الاسم : </label>
                        <span>{{ $project->contractor?->name ?? 'غير محدد' }}</span>
                    </div>

                    <div class="info-item">
                        <label>الهاتف : </label>
                        <span dir="ltr">{{ $project->contractor?->phone ?? 'غير محدد' }}</span>
                    </div>

                    <div class="info-item">
                        <label>الرقم الوطني : </label>
                        <span>{{ $project->contractor?->national_number ?? 'غير محدد' }}</span>
                    </div>

                    <div class="info-item">
                        <label>الشركة : </label>
                        <span>{{ $project->contractor?->company_name ?? 'غير محددة' }}</span>
                    </div>

                </div>


                {{-- Contract --}}
                <div class="info-card">

                    <h2 class="info-card-title">توقيع العقد</h2>

                    <div class="info-item">
                        <label>مكان التوقيع : </label>
                        <span>{{ $project->signing_location ?? 'غير محدد' }}</span>
                    </div>

                    <div class="info-item">
                        <label>تاريخ البدء : </label>
                        <span>{{ $project->start_date?->format('Y-m-d') ?? 'غير محدد' }}</span>
                    </div>

                    <div class="info-item">
                        <label>تاريخ الانتهاء : </label>
                        <span>{{ $project->end_date?->format('Y-m-d') ?? 'غير محدد' }}</span>
                    </div>

                </div>

            </section>


            {{-- ========================================================= --}}
            {{-- Pricing Items --}}
            {{-- ========================================================= --}}

            <section class="items-section">

                <div class="items-section-header">
                    <h2 class="section-title">بنود التسعير</h2>
                </div>

                <div class="table-wrapper">

                    <table class="items-table">

                        <thead>

                            <tr>

                                <th>
                                    البند
                                </th>

                                <th>
                                    صفات البند
                                </th>

                                <th>
                                    العمل المرتبط
                                </th>

                                <th>
                                    الوحدة
                                </th>

                                <th>
                                    الكمية
                                </th>

                                <th>
                                    سعر الوحدة (ل.س)
                                </th>

                                <th>
                                    الإجمالي (ل.س)
                                </th>

                                <th>
                                    سعر الوحدة ($)
                                </th>

                                <th>
                                    الإجمالي ($)
                                </th>

                                <th></th>

                                <th></th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($project->pricingItems as $item)

                                                        @php

                                                            $quantity = (float) $item->pivot->quantity;

                                                            $unitPriceSyp = (float) $item->pivot->unit_price_syp;

                                                            $unitPriceUsd = (float) $item->pivot->unit_price_usd;

                                                            $totalSyp = $quantity * $unitPriceSyp;

                                                            $totalUsd = $quantity * $unitPriceUsd;

                                                            $specifications = $item->pivot->specifications;

                                                            if (is_string($specifications)) {
                                                                $specifications = json_decode(
                                                                    $specifications,
                                                                    true
                                                                );
                                                            }

                                                            $specifications = is_array($specifications)
                                                                ? $specifications
                                                                : [];

                                                        @endphp


                                                        <tr>

                                                            {{-- Pricing Item --}}
                                                            <td class="main-label">

                                                                {{ $item->name }}

                                                            </td>


                                                            {{-- Specifications --}}
                                                            <td>

                                                                <div class="spec-chips">

                                                                    @forelse ($specifications as $specification)

                                                                        @if (is_string($specification) && trim($specification) !== '')

                                                                            <span class="chip">
                                                                                {{ $specification }}
                                                                            </span>

                                                                        @endif

                                                                    @empty

                                                                        <span>
                                                                            -
                                                                        </span>

                                                                    @endforelse

                                                                </div>

                                                            </td>


                                                            {{-- Related Work --}}
                                                            <td>

                                                                {{ $item->relatedWork?->name ?? '-' }}

                                                            </td>


                                                            {{-- Unit --}}
                                                            <td>

                                                                {{ $item->unit ?? '-' }}

                                                            </td>


                                                            {{-- Quantity --}}
                                                            <td>

                                                                {{ number_format(
                                    $quantity,
                                    3,
                                    '.',
                                    ','
                                ) }}

                                                            </td>


                                                            {{-- Unit SYP --}}
                                                            <td>

                                                                {{ number_format(
                                    $unitPriceSyp,
                                    2,
                                    '.',
                                    ','
                                ) }}

                                                            </td>


                                                            {{-- Total SYP --}}
                                                            <td class="cell-money">

                                                                {{ number_format(
                                    $totalSyp,
                                    0,
                                    '.',
                                    ','
                                ) }}

                                                            </td>


                                                            {{-- Unit USD --}}
                                                            <td>

                                                                {{ number_format(
                                    $unitPriceUsd,
                                    2,
                                    '.',
                                    ','
                                ) }}

                                                            </td>


                                                            {{-- Total USD --}}
                                                            <td class="cell-money">

                                                                {{ number_format(
                                    $totalUsd,
                                    2,
                                    '.',
                                    ','
                                ) }}

                                                            </td>


                                                            {{-- Edit --}}
                                                            <td>

                                                                <a href="{{ route(
                                    'projects.edit',
                                    $project
                                ) }}#pricing-items" class="btn-icon-edit" aria-label="تعديل بنود المشروع">

                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">

                                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />

                                                                    </svg>

                                                                </a>

                                                            </td>


                                                            {{-- Delete --}}
                                                            <td>

                                                                <button type="button" class="btn-icon-delete" aria-label="حذف بند التسعير" disabled
                                                                    title="سيتم ربط حذف البند عند إضافة مسار حذف مستقل">

                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">

                                                                        <polyline points="3 6 5 6 21 6" />

                                                                        <path
                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />

                                                                        <line x1="10" y1="11" x2="10" y2="17" />

                                                                        <line x1="14" y1="11" x2="14" y2="17" />

                                                                    </svg>

                                                                </button>

                                                            </td>

                                                        </tr>

                            @empty

                                <tr>

                                    <td colspan="11" class="empty-cell">
                                        لا توجد بنود تسعير لهذا المشروع
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>


                        @php

                            $totalSyp = $project->pricingItems->sum(
                                fn($item) =>
                                    (float) $item->pivot->quantity *
                                    (float) $item->pivot->unit_price_syp
                            );

                            $totalUsd = $project->pricingItems->sum(
                                fn($item) =>
                                    (float) $item->pivot->quantity *
                                    (float) $item->pivot->unit_price_usd
                            );

                        @endphp

                        @if ($project->pricingItems->isNotEmpty())

                            <tfoot>

                                <tr>

                                    <td class="main-label" colspan="6">
                                        الإجمالي العام
                                    </td>

                                    <td class="main-label cell-money">
                                        {{ number_format($totalSyp, 2, '.', ',') }}
                                    </td>

                                    <td></td>

                                    <td class="main-label cell-money">
                                        {{ number_format($totalUsd, 2, '.', ',') }}
                                    </td>

                                    <td></td>

                                    <td></td>

                                </tr>

                            </tfoot>

                        @endif

                    </table>

                </div>

            </section>

        </section>

    </div>

</body>

</html>