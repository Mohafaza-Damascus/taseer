```php
<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | Project
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'signing_location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'start_date' => [
                'nullable',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            /*
            |--------------------------------------------------------------------------
            | Incoming Entity
            |--------------------------------------------------------------------------
            */

            'incoming_entity_id' => [
                'nullable',
                'integer',
                'exists:incoming_entities,id',
            ],

            'new_incoming_entity_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('incoming_entities', 'name'),
            ],

            'new_incoming_entity_notes' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Contractor
            |--------------------------------------------------------------------------
            */

            'contractor_id' => [
                'nullable',
                'integer',
                'exists:contractors,id',
            ],

            'new_contractor_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'new_contractor_phone' => [
                'required_with:new_contractor_name',
                'string',
                'max:255',
            ],

            'new_contractor_national_number' => [
                'required_with:new_contractor_name',
                'string',
                'max:255',
                Rule::unique('contractors', 'national_number'),
            ],

            'new_contractor_company_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Pricing Items
            |--------------------------------------------------------------------------
            */

            'pricing_items' => [
                'nullable',
                'array',
            ],

            'pricing_items.*.pricing_item_id' => [
                'required',
                'integer',
                'distinct',
                'exists:pricing_items,id',
            ],

            'pricing_items.*.new_item_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pricing_items.*.new_item_unit' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pricing_items.*.new_item_related_work_id' => [
                'nullable',
                'exists:related_works,id',
            ],

            'pricing_items.*.new_item_related_work_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pricing_items.*.quantity' => [
                'required',
                'numeric',
                'min:0',
            ],

            'pricing_items.*.unit_price_syp' => [
                'required',
                'numeric',
                'min:0',
            ],

            'pricing_items.*.unit_price_usd' => [
                'required',
                'numeric',
                'min:0',
            ],

            'pricing_items.*.specifications' => [
                'nullable',
                'array',
            ],

            'pricing_items.*.specifications.*' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | Project
            |--------------------------------------------------------------------------
            */

            'name.required' =>
                'اسم المشروع مطلوب.',

            'name.string' =>
                'اسم المشروع يجب أن يكون نصًا.',

            'name.max' =>
                'اسم المشروع يجب ألا يتجاوز 255 محرفًا.',

            'signing_location.string' =>
                'مكان التوقيع يجب أن يكون نصًا.',

            'signing_location.max' =>
                'مكان التوقيع يجب ألا يتجاوز 255 محرفًا.',

            'start_date.date' =>
                'تاريخ البداية غير صحيح.',

            'end_date.date' =>
                'تاريخ النهاية غير صحيح.',

            'end_date.after_or_equal' =>
                'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.',

            /*
            |--------------------------------------------------------------------------
            | Incoming Entity
            |--------------------------------------------------------------------------
            */

            'incoming_entity_id.integer' =>
                'الجهة الواردة المحددة غير صحيحة.',

            'incoming_entity_id.exists' =>
                'الجهة الواردة المحددة غير موجودة.',

            'new_incoming_entity_name.string' =>
                'اسم الجهة الواردة يجب أن يكون نصًا.',

            'new_incoming_entity_name.max' =>
                'اسم الجهة الواردة يجب ألا يتجاوز 255 محرفًا.',

            'new_incoming_entity_name.unique' =>
                'اسم الجهة الواردة موجود مسبقًا.',

            'new_incoming_entity_notes.string' =>
                'ملاحظات الجهة الواردة يجب أن تكون نصًا.',

            /*
            |--------------------------------------------------------------------------
            | Contractor
            |--------------------------------------------------------------------------
            */

            'contractor_id.integer' =>
                'المتعهد المحدد غير صحيح.',

            'contractor_id.exists' =>
                'المتعهد المحدد غير موجود.',

            'new_contractor_name.string' =>
                'اسم المتعهد يجب أن يكون نصًا.',

            'new_contractor_name.max' =>
                'اسم المتعهد يجب ألا يتجاوز 255 محرفًا.',

            'new_contractor_phone.required_with' =>
                'رقم هاتف المتعهد مطلوب عند إدخال اسم المتعهد.',

            'new_contractor_phone.string' =>
                'رقم هاتف المتعهد يجب أن يكون نصًا.',

            'new_contractor_phone.max' =>
                'رقم هاتف المتعهد يجب ألا يتجاوز 255 محرفًا.',

            'new_contractor_national_number.required_with' =>
                'الرقم الوطني للمتعهد مطلوب عند إدخال اسم المتعهد.',

            'new_contractor_national_number.string' =>
                'الرقم الوطني للمتعهد يجب أن يكون نصًا.',

            'new_contractor_national_number.max' =>
                'الرقم الوطني للمتعهد يجب ألا يتجاوز 255 محرفًا.',

            'new_contractor_national_number.unique' =>
                'الرقم الوطني للمتعهد موجود مسبقًا.',

            'new_contractor_company_name.string' =>
                'اسم شركة المتعهد يجب أن يكون نصًا.',

            'new_contractor_company_name.max' =>
                'اسم شركة المتعهد يجب ألا يتجاوز 255 محرفًا.',

            /*
            |--------------------------------------------------------------------------
            | Pricing Items
            |--------------------------------------------------------------------------
            */

            'pricing_items.array' =>
                'بنود التسعير يجب أن تكون على شكل قائمة.',

            'pricing_items.*.pricing_item_id.required' =>
                'بند التسعير مطلوب.',

            'pricing_items.*.pricing_item_id.integer' =>
                'معرّف بند التسعير يجب أن يكون رقمًا.',

            'pricing_items.*.pricing_item_id.distinct' =>
                'لا يمكن إضافة نفس بند التسعير أكثر من مرة.',

            'pricing_items.*.pricing_item_id.exists' =>
                'بند التسعير المحدد غير موجود.',

            'pricing_items.*.new_item_name.string' =>
                'اسم بند التسعير الجديد يجب أن يكون نصًا.',

            'pricing_items.*.new_item_name.max' =>
                'اسم بند التسعير الجديد يجب ألا يتجاوز 255 محرفًا.',

            'pricing_items.*.new_item_unit.string' =>
                'وحدة بند التسعير الجديد يجب أن تكون نصًا.',

            'pricing_items.*.new_item_unit.max' =>
                'وحدة بند التسعير الجديد يجب ألا تتجاوز 255 محرفًا.',

            'pricing_items.*.new_item_related_work_id.exists' =>
                'العمل المرتبط المحدد غير موجود.',

            'pricing_items.*.new_item_related_work_name.string' =>
                'اسم العمل المرتبط يجب أن يكون نصًا.',

            'pricing_items.*.new_item_related_work_name.max' =>
                'اسم العمل المرتبط يجب ألا يتجاوز 255 محرفًا.',

            'pricing_items.*.quantity.required' =>
                'الكمية مطلوبة.',

            'pricing_items.*.quantity.numeric' =>
                'الكمية يجب أن تكون رقمًا.',

            'pricing_items.*.quantity.min' =>
                'الكمية لا يمكن أن تكون سالبة.',

            'pricing_items.*.unit_price_syp.required' =>
                'السعر بالليرة السورية مطلوب.',

            'pricing_items.*.unit_price_syp.numeric' =>
                'السعر بالليرة السورية يجب أن يكون رقمًا.',

            'pricing_items.*.unit_price_syp.min' =>
                'السعر بالليرة السورية لا يمكن أن يكون سالبًا.',

            'pricing_items.*.unit_price_usd.required' =>
                'السعر بالدولار مطلوب.',

            'pricing_items.*.unit_price_usd.numeric' =>
                'السعر بالدولار يجب أن يكون رقمًا.',

            'pricing_items.*.unit_price_usd.min' =>
                'السعر بالدولار لا يمكن أن يكون سالبًا.',

            'pricing_items.*.specifications.array' =>
                'المواصفات يجب أن تكون على شكل قائمة.',

            'pricing_items.*.specifications.*.string' =>
                'المواصفة يجب أن تكون نصًا.',

            'pricing_items.*.specifications.*.max' =>
                'المواصفة يجب ألا تتجاوز 255 محرفًا.',
        ];
    }
}