<?php

namespace App\Http\Requests\PricingItem;

use App\Http\Requests\BaseRequest;

class CreatePricingItemRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'unit' => [
                'nullable',
                'string',
                'max:100',
            ],

            'related_work_id' => [
                'nullable',
                'integer',
                'exists:related_works,id',
            ],

            'specifications' => [
                'nullable',
                'array',
            ],

            'specifications.*' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>
                'اسم بند التسعير مطلوب.',

            'name.string' =>
                'اسم بند التسعير يجب أن يكون نصاً.',

            'name.max' =>
                'اسم بند التسعير يجب ألا يتجاوز 255 محرفاً.',

            'unit.string' =>
                'الوحدة يجب أن تكون نصاً.',

            'unit.max' =>
                'الوحدة يجب ألا تتجاوز 100 محرف.',

            'related_work_id.integer' =>
                'العمل المرتبط غير صالح.',

            'related_work_id.exists' =>
                'العمل المرتبط المحدد غير موجود.',

            'specifications.array' =>
                'المواصفات يجب أن تكون قائمة.',

            'specifications.*.string' =>
                'كل مواصفة يجب أن تكون نصاً.',

            'specifications.*.max' =>
                'المواصفة يجب ألا تتجاوز 1000 محرف.',
        ];
    }
}