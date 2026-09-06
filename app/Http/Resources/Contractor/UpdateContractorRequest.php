<?php

namespace App\Http\Requests\Contractor;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateContractorRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $contractor = $this->route('contractor');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'sometimes',
                'required',
                'string',
                'max:50',
            ],

            'national_number' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique(
                    'contractors',
                    'national_number'
                )->ignore($contractor->id),
            ],

            'company_name' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>
                'اسم المتعهد مطلوب.',

            'name.string' =>
                'اسم المتعهد يجب أن يكون نصاً.',

            'name.max' =>
                'اسم المتعهد يجب ألا يتجاوز 255 محرفاً.',

            'phone.required' =>
                'رقم الهاتف مطلوب.',

            'phone.string' =>
                'رقم الهاتف يجب أن يكون نصاً.',

            'phone.max' =>
                'رقم الهاتف يجب ألا يتجاوز 50 محرفاً.',

            'national_number.required' =>
                'الرقم الوطني مطلوب.',

            'national_number.string' =>
                'الرقم الوطني يجب أن يكون نصاً.',

            'national_number.max' =>
                'الرقم الوطني يجب ألا يتجاوز 100 محرف.',

            'national_number.unique' =>
                'الرقم الوطني مستخدم مسبقاً.',

            'company_name.string' =>
                'اسم الشركة يجب أن يكون نصاً.',

            'company_name.max' =>
                'اسم الشركة يجب ألا تتجاوز 255 محرفاً.',
        ];
    }
}