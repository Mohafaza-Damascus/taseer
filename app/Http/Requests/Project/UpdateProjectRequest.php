<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!$this->filled('end_date')) {
                return;
            }

            $project = $this->route('project');

            if (!$project instanceof Project) {
                return;
            }

            $startDate = $this->input(
                'start_date',
                $project->start_date
            );

            if (
                $startDate !== null &&
                $this->input('end_date') < $startDate
            ) {
                $validator->errors()->add(
                    'end_date',
                    'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.'
                );
            }
        });
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