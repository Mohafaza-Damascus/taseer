<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        تعديل {{ $project->name }}
    </title>

    @vite('resources/css/variables.css')
    @vite('resources/css/projects/show.css')

</head>


<body>

    <div class="container">

        <form method="POST" action="{{ route('projects.update', $project) }}" id="projectEditForm">

            @csrf
            @method('PUT')


            {{-- ========================================================= --}}
            {{-- Header --}}
            {{-- ========================================================= --}}

            <section class="page-header">

                <div class="header-main">

                    <h1>
                        تعديل المشروع
                    </h1>


                    <div class="header-actions">

                        <a href="{{ route('projects.show', $project) }}" class="btn-icon-edit">
                            إلغاء
                        </a>


                        <button type="submit" class="btn-delete">
                            حفظ التعديلات
                        </button>

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- Project Information --}}
                {{-- ===================================================== --}}

                <section class="info-grid">


                    {{-- ================================================= --}}
                    {{-- Incoming Entity --}}
                    {{-- ================================================= --}}

                    <div class="info-card">

                        <div class="info-card-header">

                            <h2 class="info-card-title">
                                الجهة الواردة
                            </h2>

                        </div>


                        <div class="info-item">

                            <label for="incoming_entity_id">
                                الجهة :
                            </label>

                            <select id="incoming_entity_id" name="incoming_entity_id">

                                <option value="">
                                    اختر الجهة
                                </option>

                                @foreach ($incomingEntities as $entity)

                                    <option value="{{ $entity->id }}" @selected(
                                        old(
                                            'incoming_entity_id',
                                            $project->incoming_entity_id
                                        ) == $entity->id
                                    )>
                                        {{ $entity->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="info-item">

                            <label for="incoming_entity_notes">
                                ملاحظات :
                            </label>

                            <textarea id="incoming_entity_notes" name="incoming_entity_notes" rows="4">{{ old(
    'incoming_entity_notes',
    $project->incomingEntity?->notes
) }}</textarea>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- Contractor --}}
                    {{-- ================================================= --}}

                    <div class="info-card">

                        <div class="info-card-header">

                            <h2 class="info-card-title">
                                المقاول
                            </h2>

                        </div>


                        <div class="info-item">

                            <label for="contractor_id">
                                المقاول :
                            </label>

                            <select id="contractor_id" name="contractor_id">

                                <option value="">
                                    اختر المقاول
                                </option>

                                @foreach ($contractors as $contractor)

                                    <option value="{{ $contractor->id }}" @selected(
                                        old(
                                            'contractor_id',
                                            $project->contractor_id
                                        ) == $contractor->id
                                    )>
                                        {{ $contractor->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="info-item">

                            <label for="contractor_phone">
                                الهاتف :
                            </label>

                            <input type="text" id="contractor_phone" name="contractor_phone" value="{{ old(
    'contractor_phone',
    $project->contractor?->phone
) }}" dir="ltr">

                        </div>


                        <div class="info-item">

                            <label for="contractor_national_number">
                                الرقم الوطني :
                            </label>

                            <input type="text" id="contractor_national_number" name="contractor_national_number" value="{{ old(
    'contractor_national_number',
    $project->contractor?->national_number
) }}">

                        </div>


                        <div class="info-item">

                            <label for="contractor_company_name">
                                الشركة :
                            </label>

                            <input type="text" id="contractor_company_name" name="contractor_company_name" value="{{ old(
    'contractor_company_name',
    $project->contractor?->company_name
) }}">

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- Contract --}}
                    {{-- ================================================= --}}

                    <div class="info-card">

                        <div class="info-card-header">

                            <h2 class="info-card-title">
                                توقيع العقد
                            </h2>

                        </div>


                        <div class="info-item">

                            <label for="signing_location">
                                مكان التوقيع :
                            </label>

                            <input type="text" id="signing_location" name="signing_location" value="{{ old(
    'signing_location',
    $project->signing_location
) }}">

                        </div>


                        <div class="info-item">

                            <label for="start_date">
                                تاريخ البدء :
                            </label>

                            <input type="date" id="start_date" name="start_date" value="{{ old(
    'start_date',
    $project->start_date?->format('Y-m-d')
) }}">

                        </div>


                        <div class="info-item">

                            <label for="end_date">
                                تاريخ الانتهاء :
                            </label>

                            <input type="date" id="end_date" name="end_date" value="{{ old(
    'end_date',
    $project->end_date?->format('Y-m-d')
) }}">

                        </div>

                    </div>

                </section>


                {{-- ========================================================= --}}
                {{-- Project Name --}}
                {{-- ========================================================= --}}

                <div class="info-card project-name-card">

                    <div class="info-card-header">

                        <h2 class="info-card-title">
                            بيانات المشروع
                        </h2>

                    </div>


                    <div class="info-item">

                        <label for="name">
                            اسم المشروع :
                        </label>

                        <input type="text" id="name" name="name" value="{{ old(
    'name',
    $project->name
) }}" required>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- Pricing Items --}}
                {{-- ========================================================= --}}

                <section class="table-wrapper">

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

                            </tr>

                        </thead>


                        <tbody id="pricingItemsBody">

                            @forelse ($project->pricingItems as $index => $item)

                                                        @php

                                                            $quantity = (float) $item->pivot->quantity;

                                                            $unitPriceSyp =
                                                                (float) $item->pivot->unit_price_syp;

                                                            $unitPriceUsd =
                                                                (float) $item->pivot->unit_price_usd;

                                                            $totalSyp =
                                                                $quantity * $unitPriceSyp;

                                                            $totalUsd =
                                                                $quantity * $unitPriceUsd;

                                                            $specifications =
                                                                $item->pivot->specifications;

                                                            if (is_string($specifications)) {
                                                                $specifications = json_decode(
                                                                    $specifications,
                                                                    true
                                                                );
                                                            }

                                                            $specifications =
                                                                is_array($specifications)
                                                                ? $specifications
                                                                : [];

                                                        @endphp


                                                        <tr class="pricing-item-row">

                                                            {{-- ================================= --}}
                                                            {{-- Pricing Item --}}
                                                            {{-- ================================= --}}

                                                            <td class="main-label">

                                                                <select name="pricing_items[{{ $index }}][pricing_item_id]"
                                                                    class="pricing-item-select" data-index="{{ $index }}" required>

                                                                    <option value="">
                                                                        اختر البند
                                                                    </option>

                                                                    @foreach ($pricingItems as $pricingItem)

                                                                        <option value="{{ $pricingItem->id }}" @selected(
                                                                            $item->id == $pricingItem->id
                                                                        )>
                                                                            {{ $pricingItem->name }}
                                                                        </option>

                                                                    @endforeach

                                                                </select>

                                                            </td>


                                                            {{-- ================================= --}}
                                                            {{-- Specifications --}}
                                                            {{-- ================================= --}}

                                                            <td>

                                                                <select name="pricing_items[{{ $index }}][specifications][]"
                                                                    class="pricing-specifications" multiple>

                                                                    @foreach ($item->specifications as $availableSpecification)

                                                                        <option value="{{ $availableSpecification->name }}" @selected(
                                                                            in_array(
                                                                                $availableSpecification->name,
                                                                                $specifications
                                                                            )
                                                                        )>
                                                                            {{ $availableSpecification->name }}
                                                                        </option>

                                                                    @endforeach

                                                                </select>

                                                            </td>


                                                            {{-- ================================= --}}
                                                            {{-- Related Work --}}
                                                            {{-- ================================= --}}

                                                            <td>

                                                                <span class="related-work-value">
                                                                    {{ $item->relatedWork?->name ?? '-' }}
                                                                </span>

                                                            </td>


                                                            {{-- ================================= --}}
                                                            {{-- Unit --}}
                                                            {{-- ================================= --}}

                                                            <td>

                                                                <span class="unit-value">
                                                                    {{ $item->unit ?? '-' }}
                                                                </span>

                                                            </td>


                                                            {{-- ================================= --}}
                                                            {{-- Quantity --}}
                                                            {{-- ================================= --}}

                                                            <td>

                                                                <input type="number" name="pricing_items[{{ $index }}][quantity]"
                                                                    value="{{ $quantity }}" step="0.001" min="0" class="quantity-input" required>

                                                            </td>


                                                            {{-- ================================= --}}
                                                            {{-- Unit SYP --}}
                                                            {{-- ================================= --}}

                                                            <td>

                                                                <input type="number" name="pricing_items[{{ $index }}][unit_price_syp]"
                                                                    value="{{ $unitPriceSyp }}" step="0.01" min="0" class="unit-price-syp-input"
                                                                    required>

                                                            </td>


                                                            {{-- ================================= --}}
                                                            {{-- Total SYP --}}
                                                            {{-- ================================= --}}

                                                            <td class="cell-money total-syp">
                                                                {{ number_format(
                                    $totalSyp,
                                    2,
                                    '.',
                                    ','
                                ) }}
                                                            </td>


                                                            {{-- ================================= --}}
                                                            {{-- Unit USD --}}
                                                            {{-- ================================= --}}

                                                            <td>

                                                                <input type="number" name="pricing_items[{{ $index }}][unit_price_usd]"
                                                                    value="{{ $unitPriceUsd }}" step="0.01" min="0" class="unit-price-usd-input"
                                                                    required>

                                                            </td>


                                                            {{-- ================================= --}}
                                                            {{-- Total USD --}}
                                                            {{-- ================================= --}}

                                                            <td class="cell-money total-usd">
                                                                {{ number_format(
                                    $totalUsd,
                                    2,
                                    '.',
                                    ','
                                ) }}
                                                            </td>


                                                            {{-- ================================= --}}
                                                            {{-- Delete --}}
                                                            {{-- ================================= --}}

                                                            <td>

                                                                <button type="button" class="btn-icon-delete remove-pricing-item"
                                                                    aria-label="حذف البند">

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

                                {{-- سيتم إنشاء أول صف بواسطة JavaScript --}}

                            @endforelse


                            {{-- ============================================= --}}
                            {{-- Add Item --}}
                            {{-- ============================================= --}}

                            <tr>

                                <td colspan="10" class="add-item">

                                    <button type="button" id="addPricingItem">
                                        +
                                    </button>

                                </td>

                            </tr>

                        </tbody>


                        {{-- ================================================= --}}
                        {{-- Totals --}}
                        {{-- ================================================= --}}

                        <tfoot>

                            <tr>

                                <td class="main-label">
                                    الإجمالي العام
                                </td>

                                <td></td>

                                <td></td>

                                <td></td>

                                <td></td>

                                <td></td>

                                <td class="main-label" id="grandTotalSyp">
                                    0.00
                                </td>

                                <td></td>

                                <td class="main-label" id="grandTotalUsd">
                                    0.00
                                </td>

                                <td></td>

                            </tr>

                        </tfoot>

                    </table>

                </section>


                {{-- ========================================================= --}}
                {{-- Save --}}
                {{-- ========================================================= --}}

                <div class="form-actions">

                    <a href="{{ route('projects.show', $project) }}" class="btn-icon-edit">
                        إلغاء
                    </a>

                    <button type="submit" class="btn-delete">
                        حفظ التعديلات
                    </button>

                </div>

            </section>

        </form>

    </div>


    {{-- ========================================================= --}}
    {{-- Pricing Items Data --}}
    {{-- ========================================================= --}}
<script>

    const pricingItems = {{ Js::from($pricingItemsData) }};

        let pricingItemIndex =
            {{ $project->pricingItems->count() }};


        function formatNumber(value, decimals = 2) {

            return Number(value || 0).toLocaleString(
                'en-US',
                {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals
                }
            );

        }


        function updateRow(row) {

            const quantity =
                parseFloat(
                    row.querySelector('.quantity-input')?.value
                ) || 0;

            const unitSyp =
                parseFloat(
                    row.querySelector('.unit-price-syp-input')?.value
                ) || 0;

            const unitUsd =
                parseFloat(
                    row.querySelector('.unit-price-usd-input')?.value
                ) || 0;


            const totalSyp =
                quantity * unitSyp;

            const totalUsd =
                quantity * unitUsd;


            const totalSypElement =
                row.querySelector('.total-syp');

            const totalUsdElement =
                row.querySelector('.total-usd');


            if (totalSypElement) {

                totalSypElement.textContent =
                    formatNumber(totalSyp);

            }


            if (totalUsdElement) {

                totalUsdElement.textContent =
                    formatNumber(totalUsd);

            }


            updateGrandTotals();

        }


        function updateGrandTotals() {

            let totalSyp = 0;
            let totalUsd = 0;


            document
                .querySelectorAll('.pricing-item-row')
                .forEach(row => {

                    const quantity =
                        parseFloat(
                            row.querySelector(
                                '.quantity-input'
                            )?.value
                        ) || 0;

                    const unitSyp =
                        parseFloat(
                            row.querySelector(
                                '.unit-price-syp-input'
                            )?.value
                        ) || 0;

                    const unitUsd =
                        parseFloat(
                            row.querySelector(
                                '.unit-price-usd-input'
                            )?.value
                        ) || 0;


                    totalSyp +=
                        quantity * unitSyp;

                    totalUsd +=
                        quantity * unitUsd;

                });


            document.getElementById(
                'grandTotalSyp'
            ).textContent =
                formatNumber(totalSyp);


            document.getElementById(
                'grandTotalUsd'
            ).textContent =
                formatNumber(totalUsd);

        }


        function updateSpecifications(row) {

            const select =
                row.querySelector('.pricing-item-select');

            const specificationsSelect =
                row.querySelector('.pricing-specifications');

            const relatedWork =
                row.querySelector('.related-work-value');

            const unit =
                row.querySelector('.unit-value');


            if (!select) {
                return;
            }


            const selectedId =
                Number(select.value);


            const item =
                pricingItems.find(
                    pricingItem =>
                        pricingItem.id === selectedId
                );


            if (!item) {

                if (specificationsSelect) {
                    specificationsSelect.innerHTML = '';
                }

                if (relatedWork) {
                    relatedWork.textContent = '-';
                }

                if (unit) {
                    unit.textContent = '-';
                }

                return;

            }


            if (relatedWork) {

                relatedWork.textContent =
                    item.related_work || '-';

            }


            if (unit) {

                unit.textContent =
                    item.unit || '-';

            }


            if (specificationsSelect) {

                specificationsSelect.innerHTML = '';

                item.specifications.forEach(
                    specification => {

                        const option =
                            document.createElement('option');

                        option.value =
                            specification;

                        option.textContent =
                            specification;

                        specificationsSelect.appendChild(
                            option
                        );

                    }
                );

            }

        }


        function createPricingItemRow(index) {

            const row =
                document.createElement('tr');

            row.className =
                'pricing-item-row';


            let options =
                '<option value="">اختر البند</option>';


            pricingItems.forEach(item => {

                options += `
                    <option value="${item.id}">
                        ${item.name}
                    </option>
                `;

            });


            row.innerHTML = `

                <td class="main-label">

                    <select
                        name="pricing_items[${index}][pricing_item_id]"
                        class="pricing-item-select"
                        required
                    >

                        ${options}

                    </select>

                </td>


                <td>

                    <select
                        name="pricing_items[${index}][specifications][]"
                        class="pricing-specifications"
                        multiple
                    ></select>

                </td>


                <td>

                    <span class="related-work-value">
                        -
                    </span>

                </td>


                <td>

                    <span class="unit-value">
                        -
                    </span>

                </td>


                <td>

                    <input
                        type="number"
                        name="pricing_items[${index}][quantity]"
                        value="0"
                        step="0.001"
                        min="0"
                        class="quantity-input"
                        required
                    >

                </td>


                <td>

                    <input
                        type="number"
                        name="pricing_items[${index}][unit_price_syp]"
                        value="0"
                        step="0.01"
                        min="0"
                        class="unit-price-syp-input"
                        required
                    >

                </td>


                <td class="cell-money total-syp">
                    0.00
                </td>


                <td>

                    <input
                        type="number"
                        name="pricing_items[${index}][unit_price_usd]"
                        value="0"
                        step="0.01"
                        min="0"
                        class="unit-price-usd-input"
                        required
                    >

                </td>


                <td class="cell-money total-usd">
                    0.00
                </td>


                <td>

                    <button
                        type="button"
                        class="btn-icon-delete remove-pricing-item"
                        aria-label="حذف البند"
                    >
                        ×
                    </button>

                </td>

            `;


            return row;

        }


        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const body =
                    document.getElementById(
                        'pricingItemsBody'
                    );


                const addButton =
                    document.getElementById(
                        'addPricingItem'
                    );


                addButton.addEventListener(
                    'click',
                    function () {

                        const addRow =
                            body.querySelector(
                                '.add-item'
                            )?.parentElement;


                        const row =
                            createPricingItemRow(
                                pricingItemIndex
                            );


                        pricingItemIndex++;


                        body.insertBefore(
                            row,
                            addRow
                        );


                        updateGrandTotals();

                    }
                );


                body.addEventListener(
                    'click',
                    function (event) {

                        const removeButton =
                            event.target.closest(
                                '.remove-pricing-item'
                            );


                        if (!removeButton) {
                            return;
                        }


                        const row =
                            removeButton.closest(
                                '.pricing-item-row'
                            );


                        if (row) {

                            row.remove();

                            updateGrandTotals();

                        }

                    }
                );


                body.addEventListener(
                    'change',
                    function (event) {

                        const row =
                            event.target.closest(
                                '.pricing-item-row'
                            );


                        if (!row) {
                            return;
                        }


                        if (
                            event.target.classList.contains(
                                'pricing-item-select'
                            )
                        ) {

                            updateSpecifications(row);

                        }

                        updateRow(row);

                    }
                );


                body.addEventListener(
                    'input',
                    function (event) {

                        const row =
                            event.target.closest(
                                '.pricing-item-row'
                            );


                        if (!row) {
                            return;
                        }


                        if (
                            event.target.classList.contains(
                                'quantity-input'
                            ) ||
                            event.target.classList.contains(
                                'unit-price-syp-input'
                            ) ||
                            event.target.classList.contains(
                                'unit-price-usd-input'
                            )
                        ) {

                            updateRow(row);

                        }

                    }
                );


                document
                    .querySelectorAll(
                        '.pricing-item-row'
                    )
                    .forEach(row => {

                        updateRow(row);

                    });


                updateGrandTotals();

            }
        );

    </script>

</body>

</html>