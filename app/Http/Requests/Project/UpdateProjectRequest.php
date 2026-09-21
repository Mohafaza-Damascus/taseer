<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->hasPermission('projects.create');
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            $user = auth()->user();

            /*
            |--------------------------------------------------------------------------
            | Pricing Items
            |--------------------------------------------------------------------------
            */

            foreach ($this->input('pricing_items', []) as $index => $item) {

                if (
                    !empty($item['new_item_name']) &&
                    !$user->hasPermission('pricing_items.create')
                ) {
                    $validator->errors()->add(
                        "pricing_items.$index.new_item_name",
                        'لا تملك صلاحية إضافة بند جديد.'
                    );
                }

                if (
                    !empty($item['new_item_related_work_name']) &&
                    !$user->hasPermission('related_works.create')
                ) {
                    $validator->errors()->add(
                        "pricing_items.$index.new_item_related_work_name",
                        'لا تملك صلاحية إضافة عمل مرتبط جديد.'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Incoming Entity
            |--------------------------------------------------------------------------
            */

            if (
                !empty($this->input('new_incoming_entity_name')) &&
                !$user->hasPermission('incoming_entities.create')
            ) {
                $validator->errors()->add(
                    'new_incoming_entity_name',
                    'لا تملك صلاحية إضافة جهة واردة جديدة.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Contractor
            |--------------------------------------------------------------------------
            */

            if (
                !empty($this->input('new_contractor_name')) &&
                !$user->hasPermission('contractors.create')
            ) {
                $validator->errors()->add(
                    'new_contractor_name',
                    'لا تملك صلاحية إضافة متعهد جديد.'
                );
            }
        });
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
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'signing_location' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],

            'start_date' => [
                'sometimes',
                'nullable',
                'date',
            ],

            'end_date' => [
                'sometimes',
                'nullable',
                'date',
            ],

            'incoming_entity_id' => [
                'sometimes',
                'nullable',
                'integer',
                'exists:incoming_entities,id',
            ],

            'contractor_id' => [
                'sometimes',
                'nullable',
                'integer',
                'exists:contractors,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Pricing Items
            |--------------------------------------------------------------------------
            */

            'pricing_items' => [
                'sometimes',
                'array',
            ],

            'pricing_items.*.pricing_item_id' => [
                'required',
                'integer',
                'distinct',
                'exists:pricing_items,id',
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

            'incoming_entity_id.integer' =>
                'الجهة الواردة المحددة غير صحيحة.',

            'incoming_entity_id.exists' =>
                'الجهة الواردة المحددة غير موجودة.',

            'contractor_id.integer' =>
                'المتعهد المحدد غير صحيح.',

            'contractor_id.exists' =>
                'المتعهد المحدد غير موجود.',

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
        ];
    }
}