<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
                'after_or_equal:start_date',
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
             * إذا تم إرسال pricing_items
             * سيتم استبدال بنود المشروع الحالية بها.
             */
            'pricing_items' => [
                'sometimes',
                'array',
            ],

            'pricing_items.*.pricing_item_id' => [
                'required',
                'integer',
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
            'name.required' => 'اسم المشروع مطلوب.',

            'start_date.date' =>
                'تاريخ البداية غير صحيح.',

            'end_date.date' =>
                'تاريخ النهاية غير صحيح.',

            'end_date.after_or_equal' =>
                'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.',

            'incoming_entity_id.exists' =>
                'الجهة الواردة المحددة غير موجودة.',

            'contractor_id.exists' =>
                'المتعهد المحدد غير موجود.',

            'pricing_items.array' =>
                'بنود التسعير يجب أن تكون على شكل قائمة.',

            'pricing_items.*.pricing_item_id.required' =>
                'بند التسعير مطلوب.',

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

            'pricing_items.*.unit_price_usd.required' =>
                'السعر بالدولار مطلوب.',

            'pricing_items.*.unit_price_usd.numeric' =>
                'السعر بالدولار يجب أن يكون رقمًا.',

            'pricing_items.*.specifications.array' =>
                'المواصفات يجب أن تكون على شكل بيانات JSON.',
        ];
    }
}