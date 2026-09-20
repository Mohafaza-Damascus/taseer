<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إضافة مشروع</title>

    @vite('resources/css/variables.css')
    @vite('resources/css/projects/create.css')


</head>

<body>
    @php
        $canCreatePricingItems = auth()->user()->hasPermission('pricing_items.create');
    @endphp

    <div class="container">

        <form action="{{ route('projects.store') }}" method="POST" novalidate>
            @csrf

            <section class="page-header">

                <div class="header-main">

                    <h1>إضافة مشروع جديد</h1>

                    <div class="header-actions">
                        <a href="{{ route('projects.index') }}" class="btn-cancel">إلغاء</a>
                        <button type="submit" class="btn-save">حفظ المشروع</button>
                    </div>

                </div>


                <section class="info-grid">

                    {{-- الجهة الواردة --}}
                    <div class="info-card">

                        <div class="info-card-header">
                            <h2 class="info-card-title">الجهة الواردة</h2>
                        </div>

                        <div id="incomingEntity-select-wrapper">
                            <div class="info-item">
                                <label for="incoming_entity_id">الاسم :</label>
                                <select id="incoming_entity_id" name="incoming_entity_id">
                                    <option value="">اختر الجهة الواردة</option>
                                    @foreach($incomingEntities as $incomingEntity)
                                        <option value="{{ $incomingEntity->id }}"
                                            @selected(old('incoming_entity_id') == $incomingEntity->id)>
                                            {{ $incomingEntity->name }}
                                        </option>
                                    @endforeach
                                    <option value="__other__">أخرى</option>
                                </select>
                            </div>
                        </div>

                        <div id="incomingEntity-new-wrapper" style="display: none;">
                            <div class="new-fields" style="grid-template-columns: 1fr;">
                                <div class="info-item">
                                    <label for="new_incoming_entity_name">اسم الجهة :</label>
                                    <input type="text" id="new_incoming_entity_name" name="new_incoming_entity_name"
                                        value="{{ old('new_incoming_entity_name') }}"
                                        placeholder="أدخل اسم الجهة الواردة">
                                </div>
                                <div class="info-item">
                                    <label for="new_incoming_entity_notes">ملاحظات :</label>
                                    <textarea id="new_incoming_entity_notes" name="new_incoming_entity_notes" rows="3"
                                        placeholder="ملاحظات (اختياري)">{{ old('new_incoming_entity_notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>


                    {{-- المقاول --}}
                    <div class="info-card">

                        <div class="info-card-header">
                            <h2 class="info-card-title">المقاول</h2>
                        </div>

                        <div id="contractor-select-wrapper">
                            <div class="info-item">
                                <label for="contractor_id">الاسم :</label>
                                <select id="contractor_id" name="contractor_id">
                                    <option value="">اختر المقاول</option>
                                    @foreach($contractors as $contractor)
                                        <option value="{{ $contractor->id }}"
                                            @selected(old('contractor_id') == $contractor->id)>
                                            {{ $contractor->name }}
                                            @if($contractor->company_name) - {{ $contractor->company_name }} @endif
                                        </option>
                                    @endforeach
                                    <option value="__other__">أخرى</option>
                                </select>
                            </div>
                        </div>

                        <div id="contractor-new-wrapper" style="display: none;">
                            <div class="new-fields">
                                <div class="info-item">
                                    <label for="new_contractor_name">اسم المقاول :</label>
                                    <input type="text" id="new_contractor_name" name="new_contractor_name"
                                        value="{{ old('new_contractor_name') }}" placeholder="الاسم الكامل">
                                </div>
                                <div class="info-item">
                                    <label for="new_contractor_national_number">الرقم الوطني :</label>
                                    <input type="text" id="new_contractor_national_number"
                                        name="new_contractor_national_number"
                                        value="{{ old('new_contractor_national_number') }}" placeholder="الرقم الوطني">
                                </div>
                                <div class="info-item">
                                    <label for="new_contractor_phone">الهاتف :</label>
                                    <input type="text" id="new_contractor_phone" name="new_contractor_phone"
                                        value="{{ old('new_contractor_phone') }}" placeholder="رقم الهاتف">
                                </div>
                                <div class="info-item">
                                    <label for="new_contractor_company_name">اسم الشركة :</label>
                                    <input type="text" id="new_contractor_company_name"
                                        name="new_contractor_company_name"
                                        value="{{ old('new_contractor_company_name') }}" placeholder="اختياري">
                                </div>
                            </div>
                        </div>

                    </div>


                    {{-- بيانات العقد --}}
                    <div class="info-card">

                        <div class="info-card-header">
                            <h2 class="info-card-title">توقيع العقد</h2>
                        </div>

                        <div class="info-item">
                            <label for="signing_location">مكان التوقيع :</label>
                            <input type="text" id="signing_location" name="signing_location"
                                value="{{ old('signing_location') }}" placeholder="أدخل مكان توقيع العقد">
                        </div>

                        <div class="info-item">
                            <label for="start_date">تاريخ البدء :</label>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}">
                        </div>

                        <div class="info-item">
                            <label for="end_date">تاريخ الانتهاء :</label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        </div>

                    </div>

                </section>


                {{-- اسم المشروع --}}
                <section class="info-card">

                    <div class="info-card-header">
                        <h2 class="info-card-title">بيانات المشروع</h2>
                    </div>

                    <div class="info-item">

                        <label for="name">
                            اسم المشروع :
                        </label>

                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="أدخل اسم المشروع" class="@error('name') input-error @enderror" required>

                        @error('name')
                            <span class="form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </section>


                {{-- بنود المشروع --}}
                <section class="table-wrapper">

                    <table class="items-table">

                        <thead>
                            <tr>
                                <th>البند</th>
                                <th>صفة البند</th>
                                <th>العمل المرتبط</th>
                                <th>الوحدة</th>
                                <th>الكمية</th>
                                <th>سعر الوحدة (ل.س)</th>
                                <th>الإجمالي (ل.س)</th>
                                <th>سعر الوحدة ($)</th>
                                <th>الإجمالي ($)</th>
                                <th class="col-actions">
                                    @if($canCreatePricingItems)
                                        <button type="button" class="btn-icon-add" id="addPricingItem"
                                            aria-label="إضافة بند">
                                            +
                                        </button>
                                    @endif
                                </th>
                            </tr>
                        </thead>

                        <tbody id="pricingItemsBody">

                            <tr id="emptyItemsRow">
                                <td colspan="10" class="empty-cell">
                                    لم تتم إضافة أي بند بعد
                                </td>
                            </tr>

                        </tbody>

                        <tfoot>
                            <tr>
                                <td class="main-label" colspan="6">الإجمالي العام</td>
                                <td class="main-label cell-money" id="totalSyp">0.00</td>
                                <td></td>
                                <td class="main-label cell-money" id="totalUsd">0.00</td>
                                <td class="col-actions"></td>
                            </tr>
                        </tfoot>

                    </table>

                </section>

            </section>

        </form>

    </div>


    <script>

        const pricingItems = @json($pricingItems);
        const relatedWorks = @json($relatedWorks ?? []);
        const oldPricingItems = @json(old('pricing_items', []));

        let itemIndex = 0;

        const tbody = document.getElementById('pricingItemsBody');
        const addButton = document.getElementById('addPricingItem');


        function setupEntitySelector(field, selectId) {

            const select = document.getElementById(selectId);
            const newWrapper = document.getElementById(field + '-new-wrapper');
            const newFields = newWrapper.querySelectorAll('input, textarea');

            const originalName = select.name;
            let hiddenInput = null;

            function setMode(mode) {

                if (mode === 'new') {

                    newWrapper.style.display = '';
                    newFields.forEach(f => f.disabled = false);

                    select.value = '__other__';
                    select.name = '';

                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = originalName;
                        hiddenInput.value = '';
                        select.parentNode.appendChild(hiddenInput);
                    }

                } else {

                    newWrapper.style.display = 'none';
                    newFields.forEach(f => f.disabled = true);

                    select.name = originalName;

                    if (hiddenInput) {
                        hiddenInput.remove();
                        hiddenInput = null;
                    }

                }
            }

            select.addEventListener('change', function () {
                if (this.value === '__other__') {
                    setMode('new');
                } else {
                    setMode('select');
                }
            });

            const hasOldNewValues = Array.from(newFields).some(f => f.value.trim() !== '');

            if (hasOldNewValues) {
                setMode('new');
            } else {
                setMode('select');
            }
        }

        setupEntitySelector('incomingEntity', 'incoming_entity_id');
        setupEntitySelector('contractor', 'contractor_id');



        function setRowMode(row, mode) {

            const select     = row.querySelector('.pricing-item-select');
            const newWrap    = row.querySelector('.item-new-wrapper');
            const newName    = row.querySelector('.new-item-name');

            const unitLabel  = row.querySelector('.unit-label');
            const unitInput  = row.querySelector('.new-item-unit');

            const relatedWrap  = row.querySelector('.related-cell-wrap');
            const relatedLabel = row.querySelector('.related-work');

            const originalName = select.dataset.originalName;
            let hiddenInput = select.parentNode.querySelector('.pricing-item-hidden');

            if (mode === 'new') {

                newWrap.style.display = '';
                newName.disabled = false;
                newName.required = true;

                unitLabel.style.display = 'none';
                unitInput.style.display = '';
                unitInput.disabled = false;

                relatedLabel.style.display = 'none';
                relatedWrap.style.display = '';

                select.name = '';
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.className = 'pricing-item-hidden';
                    hiddenInput.name = originalName;
                    hiddenInput.value = '';
                    select.parentNode.appendChild(hiddenInput);
                }

            } else {

                newWrap.style.display = 'none';
                newName.disabled = true;
                newName.required = false;

                unitLabel.style.display = '';
                unitInput.style.display = 'none';
                unitInput.disabled = true;

                relatedWrap.style.display = 'none';
                relatedLabel.style.display = '';

                select.name = originalName;
                if (hiddenInput) {
                    hiddenInput.remove();
                }

            }
        }



        function setRelatedMode(row, mode) {

            const select     = row.querySelector('.new-item-related-work');
            const newInput   = row.querySelector('.new-item-related-work-name');

            const originalName = select.dataset.originalName;
            let hiddenInput = select.parentNode.querySelector('.related-work-hidden');

            if (mode === 'new') {

                newInput.style.display = '';
                newInput.disabled = false;
                newInput.required = true;

                select.name = '';
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.className = 'related-work-hidden';
                    hiddenInput.name = originalName;
                    hiddenInput.value = '';
                    select.parentNode.appendChild(hiddenInput);
                }

            } else {

                newInput.style.display = 'none';
                newInput.disabled = true;
                newInput.required = false;

                select.name = originalName;
                if (hiddenInput) {
                    hiddenInput.remove();
                }

            }
        }



        function setupRow(row) {

            const select        = row.querySelector('.pricing-item-select');
            const unitLabel     = row.querySelector('.unit-label');
            const relatedLabel  = row.querySelector('.related-work');
            const specInput     = row.querySelector('.spec-input');

            const relatedSelect = row.querySelector('.new-item-related-work');

            const quantity      = row.querySelector('.quantity');
            const unitPriceSyp  = row.querySelector('.unit-price-syp');
            const unitPriceUsd  = row.querySelector('.unit-price-usd');

            const totalSyp      = row.querySelector('.total-syp');
            const totalUsd      = row.querySelector('.total-usd');

            const removeButton  = row.querySelector('.remove-item');


            select.addEventListener('change', function () {

                if (this.value === '__other__') {
                    setRowMode(row, 'new');
                    specInput.value = '';
                    return;
                }

                setRowMode(row, 'select');

                const option = this.options[this.selectedIndex];

                unitLabel.textContent = option.dataset.unit || '-';
                relatedLabel.textContent = option.dataset.relatedWork || '-';

                let specs = [];
                try {
                    specs = JSON.parse(option.dataset.specs || '[]');
                } catch (e) {
                    specs = [];
                }

                specInput.value = specs.length ? (specs[0] ?? '') : '';
            });


            relatedSelect.addEventListener('change', function () {
                if (this.value === '__other__') {
                    setRelatedMode(row, 'new');
                } else {
                    setRelatedMode(row, 'select');
                }
            });

            setRelatedMode(row, 'select');


            function calculateTotals() {

                const qty = parseFloat(quantity.value) || 0;
                const syp = parseFloat(unitPriceSyp.value) || 0;
                const usd = parseFloat(unitPriceUsd.value) || 0;

                const options = {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                };

                totalSyp.textContent = (qty * syp).toLocaleString('en-US', options);
                totalUsd.textContent = (qty * usd).toLocaleString('en-US', options);

                calculateGrandTotals();
            }

            quantity.addEventListener('input', calculateTotals);
            unitPriceSyp.addEventListener('input', calculateTotals);
            unitPriceUsd.addEventListener('input', calculateTotals);


            removeButton.addEventListener('click', function () {
                row.remove();
                refreshEmptyRow();
                calculateGrandTotals();
            });

            setRowMode(row, 'select');
        }



        function addPricingItem(overrides = {}) {

            const emptyRow = document.getElementById('emptyItemsRow');
            if (emptyRow) {
                emptyRow.remove();
            }

            const row = document.createElement('tr');
            row.dataset.index = itemIndex;

            row.innerHTML = `

                <td class="item-cell">


                    <div class="item-select-wrapper">
                        <select
                            name="pricing_items[${itemIndex}][pricing_item_id]"
                            class="pricing-item-select"
                            data-original-name="pricing_items[${itemIndex}][pricing_item_id]"
                            required
                        >
                            <option value="">اختر البند</option>
                            ${pricingItems.map(item => `
                                <option
                                    value="${item.id}"
                                    data-unit="${item.unit ?? ''}"
                                    data-related-work="${item.related_work?.name ?? ''}"
                                    data-specs="${JSON.stringify(
                                        (item.specifications ?? []).map(s => s.name)
                                    ).replace(/"/g, '&quot;')}"
                                >
                                    ${item.name}
                                </option>
                            `).join('')}
                            <option value="__other__">أخرى</option>
                        </select>
                    </div>

                    <div class="item-new-wrapper" style="display: none;">
                        <input
                            type="text"
                            name="pricing_items[${itemIndex}][new_item_name]"
                            class="new-item-name"
                            placeholder="اسم البند الجديد"
                        >
                    </div>

                </td>


                <td>
                    <input
                        type="text"
                        name="pricing_items[${itemIndex}][specifications][]"
                        class="spec-input"
                        placeholder="صفة البند"
                    >
                </td>


                <td>
                    <span class="related-work">-</span>

                    <div class="related-cell-wrap" style="display: none;">

                        <select
                            class="new-item-related-work"
                            name="pricing_items[${itemIndex}][new_item_related_work_id]"
                            data-original-name="pricing_items[${itemIndex}][new_item_related_work_id]"
                        >
                            <option value="">اختر العمل</option>
                            ${relatedWorks.map(work => `
                                <option value="${work.id}">${work.name}</option>
                            `).join('')}
                            <option value="__other__">أخرى</option>
                        </select>

                        <input
                            type="text"
                            class="new-item-related-work-name"
                            name="pricing_items[${itemIndex}][new_item_related_work_name]"
                            placeholder="اسم عمل جديد"
                            style="display: none;"
                        >

                    </div>
                </td>


                <td>
                    <span class="unit-label">-</span>
                    <input
                        type="text"
                        class="new-item-unit"
                        name="pricing_items[${itemIndex}][new_item_unit]"
                        placeholder="الوحدة"
                        style="display: none;"
                    >
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

                    <span
                        class="form-error"
                        data-error="pricing_items.${itemIndex}.quantity"
                    ></span>
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

                    <span
                        class="form-error"
                        data-error="pricing_items.${itemIndex}.unit_price_syp"
                    ></span>
                </td>

                <td class="cell-money total-syp">0.00</td>

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

                    <span
                        class="form-error"
                        data-error="pricing_items.${itemIndex}.unit_price_usd"
                    ></span>
                </td>

                <td class="cell-money total-usd">0.00</td>


                <td class="col-actions">
                    <button type="button" class="btn-icon-delete remove-item" aria-label="حذف البند">×</button>
                </td>

            `;

            tbody.appendChild(row);

            itemIndex++;

            setupRow(row);


            if (overrides.pricing_item_id) {
                const select = row.querySelector('.pricing-item-select');
                select.value = overrides.pricing_item_id;
                select.dispatchEvent(new Event('change'));
            }

            if (overrides.new_item_name) {
                const select = row.querySelector('.pricing-item-select');
                select.value = '__other__';
                select.dispatchEvent(new Event('change'));

                row.querySelector('.new-item-name').value = overrides.new_item_name;
                row.querySelector('.new-item-unit').value = overrides.new_item_unit ?? '';

                if (overrides.new_item_related_work_name) {
                    const relatedSelect = row.querySelector('.new-item-related-work');
                    relatedSelect.value = '__other__';
                    relatedSelect.dispatchEvent(new Event('change'));
                    row.querySelector('.new-item-related-work-name').value = overrides.new_item_related_work_name;
                } else if (overrides.new_item_related_work_id) {
                    row.querySelector('.new-item-related-work').value = overrides.new_item_related_work_id;
                }
            }

            if (overrides.specifications && overrides.specifications.length) {
                row.querySelector('.spec-input').value = overrides.specifications[0] ?? '';
            }

            if (overrides.quantity !== undefined) row.querySelector('.quantity').value = overrides.quantity;
            if (overrides.unit_price_syp !== undefined) row.querySelector('.unit-price-syp').value = overrides.unit_price_syp;
            if (overrides.unit_price_usd !== undefined) row.querySelector('.unit-price-usd').value = overrides.unit_price_usd;

            row.querySelector('.quantity').dispatchEvent(new Event('input'));

        }


        function refreshEmptyRow() {

            const hasRows = tbody.querySelector('tr[data-index]');

            if (!hasRows && !document.getElementById('emptyItemsRow')) {
                const tr = document.createElement('tr');
                tr.id = 'emptyItemsRow';
                tr.innerHTML = `
                    <td colspan="10" class="empty-cell">
                        لم تتم إضافة أي بند بعد
                    </td>
                `;
                tbody.appendChild(tr);
            }

        }


        function calculateGrandTotals() {

            let totalSyp = 0;
            let totalUsd = 0;

            document
                .querySelectorAll('#pricingItemsBody tr[data-index]')
                .forEach(row => {

                    const quantity = parseFloat(row.querySelector('.quantity')?.value) || 0;
                    const syp = parseFloat(row.querySelector('.unit-price-syp')?.value) || 0;
                    const usd = parseFloat(row.querySelector('.unit-price-usd')?.value) || 0;

                    totalSyp += quantity * syp;
                    totalUsd += quantity * usd;

                });


            const options = {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            };

            document.getElementById('totalSyp').textContent =
                totalSyp.toLocaleString('en-US', options);

            document.getElementById('totalUsd').textContent =
                totalUsd.toLocaleString('en-US', options);

        }


        addButton.addEventListener('click', () => addPricingItem());


        oldPricingItems.forEach(item => addPricingItem(item));

    </script>

</body>

</html>
