<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إضافة مشروع</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/projects/show.css')
</head>

<body>

    <div class="container">

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <section class="page-header">

                <div class="header-main">

                    <h1>إضافة مشروع جديد</h1>

                </div>


                <section class="info-grid">

                    {{-- الجهة الواردة --}}
                    <div class="info-card">

                        <div class="info-card-header">
                            <h2 class="info-card-title">
                                الجهة الواردة
                            </h2>
                        </div>

                        <div class="info-item">

                            <label for="incoming_entity_id">
                                الاسم :
                            </label>

                            <select id="incoming_entity_id" name="incoming_entity_id">
                                <option value="">
                                    اختر الجهة الواردة
                                </option>

                                @foreach($incomingEntities as $incomingEntity)
                                    <option value="{{ $incomingEntity->id }}" @selected(
                                        old('incoming_entity_id') == $incomingEntity->id
                                    )>
                                        {{ $incomingEntity->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                    </div>


                    {{-- المقاول --}}
                    <div class="info-card">

                        <div class="info-card-header">
                            <h2 class="info-card-title">
                                المقاول
                            </h2>
                        </div>

                        <div class="info-item">

                            <label for="contractor_id">
                                الاسم :
                            </label>

                            <select id="contractor_id" name="contractor_id">
                                <option value="">
                                    اختر المقاول
                                </option>

                                @foreach($contractors as $contractor)
                                    <option value="{{ $contractor->id }}" @selected(
                                        old('contractor_id') == $contractor->id
                                    )>
                                        {{ $contractor->name }}
                                        @if($contractor->company_name)
                                            - {{ $contractor->company_name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>

                        </div>

                    </div>


                    {{-- بيانات العقد --}}
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

                            <input type="text" id="signing_location" name="signing_location"
                                value="{{ old('signing_location') }}" placeholder="أدخل مكان توقيع العقد">

                        </div>

                        <div class="info-item">

                            <label for="start_date">
                                تاريخ البدء :
                            </label>

                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}">

                        </div>

                        <div class="info-item">

                            <label for="end_date">
                                تاريخ الانتهاء :
                            </label>

                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}">

                        </div>

                    </div>

                </section>


                {{-- اسم المشروع --}}
                <section class="info-card">

                    <div class="info-card-header">

                        <h2 class="info-card-title">
                            بيانات المشروع
                        </h2>

                    </div>

                    <div class="info-item">

                        <label for="name">
                            اسم المشروع :
                        </label>

                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="أدخل اسم المشروع" required>

                    </div>

                </section>


                {{-- بنود المشروع --}}
                <section class="table-wrapper">

                    <table class="items-table">

                        <thead>

                            <tr>
                                <th>البند</th>
                                <th>صفات البند</th>
                                <th>العمل المرتبط</th>
                                <th>الوحدة</th>
                                <th>الكمية</th>
                                <th>سعر الوحدة (ل.س)</th>
                                <th>الإجمالي (ل.س)</th>
                                <th>سعر الوحدة ($)</th>
                                <th>الإجمالي ($)</th>
                                <th></th>
                                <th></th>
                            </tr>

                        </thead>


                        <tbody id="pricingItemsBody">

                            <tr id="emptyItemsRow">

                                <td colspan="11" style="text-align: center;">
                                    لم تتم إضافة أي بند بعد
                                </td>

                            </tr>

                            <tr>

                                <td colspan="11" class="add-item" id="addPricingItem" style="cursor: pointer;">
                                    +
                                </td>

                            </tr>

                        </tbody>


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

                                <td class="main-label" id="totalSyp">
                                    0.00
                                </td>

                                <td></td>

                                <td class="main-label" id="totalUsd">
                                    0.00
                                </td>

                                <td></td>
                                <td></td>

                            </tr>

                        </tfoot>

                    </table>

                </section>


                {{-- أزرار الحفظ --}}
                <div class="header-actions" style="margin-top: 30px;">

                    <a href="{{ route('projects.index') }}" class="btn-delete">
                        إلغاء
                    </a>

                    <button type="submit" class="btn-save">
                        حفظ المشروع
                    </button>

                </div>

            </section>

        </form>

    </div>


    <script>

        const pricingItems = @json($pricingItems);

        let itemIndex = 0;

        const tbody = document.getElementById('pricingItemsBody');
        const addButton = document.getElementById('addPricingItem');
        const emptyRow = document.getElementById('emptyItemsRow');

        function addPricingItem() {

            if (emptyRow) {
                emptyRow.remove();
            }

            const row = document.createElement('tr');

            row.dataset.index = itemIndex;

            row.innerHTML = `

            <td class="main-label">

                <select
                    name="pricing_items[${itemIndex}][pricing_item_id]"
                    class="pricing-item-select"
                    required
                >

                    <option value="">
                        اختر البند
                    </option>

                    ${pricingItems.map(item => `
                        <option
                            value="${item.id}"
                            data-unit="${item.unit ?? ''}"
                            data-related-work="${item.related_work?.name ?? ''}"
                        >
                            ${item.name}
                        </option>
                    `).join('')}

                </select>

            </td>


            <td>

                <div class="spec-chips">

                    <input
                        type="text"
                        name="pricing_items[${itemIndex}][specifications][]"
                        placeholder="صفة البند"
                    >

                </div>

            </td>


            <td class="related-work">
                -
            </td>


            <td class="unit">
                -
            </td>


            <td>

                <input
                    type="number"
                    name="pricing_items[${itemIndex}][quantity]"
                    class="quantity"
                    min="0"
                    step="0.001"
                    value="0"
                    required
                >

            </td>


            <td>

                <input
                    type="number"
                    name="pricing_items[${itemIndex}][unit_price_syp]"
                    class="unit-price-syp"
                    min="0"
                    step="0.01"
                    value="0"
                    required
                >

            </td>


            <td class="cell-money total-syp">
                0.00
            </td>


            <td>

                <input
                    type="number"
                    name="pricing_items[${itemIndex}][unit_price_usd]"
                    class="unit-price-usd"
                    min="0"
                    step="0.01"
                    value="0"
                    required
                >

            </td>


            <td class="cell-money total-usd">
                0.00
            </td>


            <td>

                <button
                    type="button"
                    class="btn-icon-delete remove-item"
                    aria-label="حذف البند"
                >
                    ×
                </button>

            </td>


            <td></td>

        `;

            tbody.insertBefore(
                row,
                addButton.parentElement
            );

            itemIndex++;

            setupRow(row);
        }


        function setupRow(row) {

            const select = row.querySelector(
                '.pricing-item-select'
            );

            const quantity = row.querySelector(
                '.quantity'
            );

            const unitPriceSyp = row.querySelector(
                '.unit-price-syp'
            );

            const unitPriceUsd = row.querySelector(
                '.unit-price-usd'
            );

            const relatedWork = row.querySelector(
                '.related-work'
            );

            const unit = row.querySelector(
                '.unit'
            );

            const totalSyp = row.querySelector(
                '.total-syp'
            );

            const totalUsd = row.querySelector(
                '.total-usd'
            );

            const removeButton = row.querySelector(
                '.remove-item'
            );


            select.addEventListener(
                'change',
                function () {

                    const option =
                        this.options[this.selectedIndex];

                    unit.textContent =
                        option.dataset.unit || '-';

                    relatedWork.textContent =
                        option.dataset.relatedWork || '-';

                }
            );


            function calculateTotals() {

                const qty =
                    parseFloat(quantity.value) || 0;

                const syp =
                    parseFloat(unitPriceSyp.value) || 0;

                const usd =
                    parseFloat(unitPriceUsd.value) || 0;

                totalSyp.textContent =
                    (qty * syp).toLocaleString(
                        'en-US',
                        {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }
                    );

                totalUsd.textContent =
                    (qty * usd).toLocaleString(
                        'en-US',
                        {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }
                    );

                calculateGrandTotals();
            }


            quantity.addEventListener(
                'input',
                calculateTotals
            );

            unitPriceSyp.addEventListener(
                'input',
                calculateTotals
            );

            unitPriceUsd.addEventListener(
                'input',
                calculateTotals
            );


            removeButton.addEventListener(
                'click',
                function () {

                    row.remove();

                    calculateGrandTotals();

                }
            );

        }


        function calculateGrandTotals() {

            let totalSyp = 0;
            let totalUsd = 0;

            document
                .querySelectorAll('#pricingItemsBody tr[data-index]')
                .forEach(row => {

                    const quantity =
                        parseFloat(
                            row.querySelector('.quantity')?.value
                        ) || 0;

                    const syp =
                        parseFloat(
                            row.querySelector('.unit-price-syp')?.value
                        ) || 0;

                    const usd =
                        parseFloat(
                            row.querySelector('.unit-price-usd')?.value
                        ) || 0;

                    totalSyp += quantity * syp;
                    totalUsd += quantity * usd;

                });


            document.getElementById('totalSyp').textContent =
                totalSyp.toLocaleString(
                    'en-US',
                    {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );


            document.getElementById('totalUsd').textContent =
                totalUsd.toLocaleString(
                    'en-US',
                    {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );

        }


        addButton.addEventListener(
            'click',
            addPricingItem
        );

    </script>

</body>

</html>