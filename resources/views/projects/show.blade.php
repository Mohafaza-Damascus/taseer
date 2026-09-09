<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المشروع</title>
    @vite('resources/css/variables.css')
    @vite('resources/css/dashboard/show.css')
</head>

<body>
    <div class="container">
        <section class="page-header">

            <div class="header-main">
                <h1>مشروع بناء مجمع سكني</h1>

                <div class="header-actions">
                    <button type="button" class="btn-delete">حذف المشروع</button>
                </div>
            </div>

            <section class="info-grid">
                <div class="info-card">

                    <div class="info-card-header">
                        <h2 class="info-card-title">الجهة الواردة</h2>
                        <button class="btn-icon-edit" type="button" aria-label="تعديل بيانات الجهة الواردة">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="info-item">
                        <label>الاسم :</label>
                        <span>وزارة الإسكان</span>
                    </div>
                    <div class="info-item">
                        <label>ملاحظات :</label>
                        <span>الجهة المشرفة على المشروع هي المديرية الفنية في الوزارة. يتم تقديم كشف حساب شهري عن سير
                            الأعمال، وتُستلم المراحل بواسطة لجنة فنية مشكلة من الوزارة.</span>
                    </div>

                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <h2 class="info-card-title">المقاول</h2>
                        <button class="btn-icon-edit" type="button" aria-label="تعديل بيانات الجهة الواردة">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="info-item">
                        <label>الاسم :</label>
                        <span>أحمد محمد الخطيب</span>
                    </div>
                    <div class="info-item">
                        <label>الهاتف :</label>
                        <span dir="ltr">+963 931 234 567</span>
                    </div>
                    <div class="info-item">
                        <label>الرقم الوطني :</label>
                        <span>02010123456</span>
                    </div>
                    <div class="info-item">
                        <label>الشركة :</label>
                        <span>شركة البناء الحديث للمقاولات</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <h2 class="info-card-title">توقيع العقد</h2>
                        <button class="btn-icon-edit" type="button" aria-label="تعديل بيانات الجهة الواردة">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="info-item">
                        <label>مكان التوقيع :</label>
                        <span>دمشق — مبنى وزارة الإسكان</span>
                    </div>
                    <div class="info-item">
                        <label>تاريخ البدء :</label>
                        <span>2025-01-15</span>
                    </div>
                    <div class="info-item">
                        <label>تاريخ الانتهاء :</label>
                        <span>2025-12-30</span>
                    </div>
                </div>

            </section>

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
                    <tbody>
                        <tr>
                            <td class="main-label">
                                أعمال الحفر والردم
                            </td>
                            <td>
                                <div class="spec-chips">
                                    <span class="chip">حفر يدوي</span>
                                    <span class="chip">ردم مدمك</span>
                                </div>
                            </td>
                            <td>أعمال ترابية</td>
                            <td>م³</td>
                            <td>1,250.000</td>
                            <td>18,000.00</td>
                            <td class="cell-money">22,500,000.00</td>
                            <td>12.20</td>
                            <td class="cell-money">15,250.00</td>
                            <td>
                                <button class="btn-icon-edit" type="button" aria-label="تعديل بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button class="btn-icon-delete" type="button" aria-label="حذف بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="main-label">
                                خرسانة مسلحة للقواعد والسقوف
                            </td>
                            <td>
                                <div class="spec-chips">
                                    <span class="chip">C30</span>
                                    <span class="chip">مقاومة عالية</span>
                                    <span class="chip">بإشراف هندسي</span>
                                </div>
                            </td>
                            <td>أعمال إنشائية</td>
                            <td>م³</td>
                            <td>680.000</td>
                            <td>145,000.00</td>
                            <td class="cell-money">98,600,000.00</td>
                            <td>98.00</td>
                            <td class="cell-money">66,640.00</td>
                            <td>
                                <button class="btn-icon-edit" type="button" aria-label="تعديل بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button class="btn-icon-delete" type="button" aria-label="حذف بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="main-label">
                                حديد تسليح
                            </td>
                            <td>
                                <div class="spec-chips">
                                    <span class="chip">درجة 60</span>
                                    <span class="chip">قطر 12-25 مم</span>
                                </div>
                            </td>
                            <td>أعمال إنشائية</td>
                            <td>طن</td>
                            <td>95.000</td>
                            <td>950,000.00</td>
                            <td>90,250,000.00</td>
                            <td>640.00</td>
                            <td>60,800.00</td>
                            <td>
                                <button class="btn-icon-edit" type="button" aria-label="تعديل بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button class="btn-icon-delete" type="button" aria-label="حذف بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="main-label">
                                أعمال المباني (بلوك)
                            </td>
                            <td>
                                <div class="spec-chips">
                                    <span class="chip">بلوك 20 سم</span>
                                </div>
                            </td>
                            <td>أعمال بناء</td>
                            <td>م²</td>
                            <td>4,200.000</td>
                            <td>8,500.00</td>
                            <td>35,700,000.00</td>
                            <td>5.75</td>
                            <td>24,150.00</td>
                            <td>
                                <button class="btn-icon-edit" type="button" aria-label="تعديل بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button class="btn-icon-delete" type="button" aria-label="حذف بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="main-label">
                                دهانات داخلية وخارجية
                            </td>
                            <td>
                                <div class="spec-chips">
                                    <span class="chip">بلاستيك</span>
                                    <span class="chip">زيتي</span>
                                    <span class="chip">درجة أولى</span>
                                </div>
                            </td>
                            <td>أعمال تشطيب</td>
                            <td>م²</td>
                            <td>6,800.000</td>
                            <td>6,200.00</td>
                            <td>42,160,000.00</td>
                            <td>4.20</td>
                            <td>28,560.00</td>
                            <td>
                                <button class="btn-icon-edit" type="button" aria-label="تعديل بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button class="btn-icon-delete" type="button" aria-label="حذف بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="main-label">
                                ألمنيوم ونوافذ زجاجية
                            </td>
                            <td>
                                <div class="spec-chips">
                                    <span class="chip">بروفايل ألمنيوم</span>
                                    <span class="chip">زجاج مزدوج</span>
                                </div>
                            </td>
                            <td>أعمال تشطيب</td>
                            <td>م²</td>
                            <td>520.000</td>
                            <td>89,000.00</td>
                            <td>46,280,000.00</td>
                            <td>60.00</td>
                            <td>31,200.00</td>
                            <td>
                                <button class="btn-icon-edit" type="button" aria-label="تعديل بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <button class="btn-icon-delete" type="button" aria-label="حذف بيانات الجهة الواردة">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" class="add-item">+</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="main-label">الإجمالي العام</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="main-label">335,750,000.00</td>
                            <td></td>
                            <td class="main-label">228,480.00</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </section>

            </header>


    </div>
</body>
</html>
