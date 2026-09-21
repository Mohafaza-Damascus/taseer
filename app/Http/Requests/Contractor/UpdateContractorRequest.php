<?php

namespace App\Http\Requests\Contractor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContractorRequest extends FormRequest
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
                'regex:/^09[0-9]{8}$/',
            ],

            'national_number' => [
                'sometimes',
                'required',
                'string',
                'regex:/^[0-9]{11}$/',
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

            'phone.regex' =>
                'رقم الهاتف يجب أن يكون 10 أرقام ويبدأ بـ 09.',

            'national_number.required' =>
                'الرقم الوطني مطلوب.',

            'national_number.regex' =>
                'الرقم الوطني يجب أن يكون 11 رقماً.',

            'national_number.unique' =>
                'الرقم الوطني مستخدم مسبقاً.',

            'company_name.string' =>
                'اسم الشركة يجب أن يكون نصاً.',

            'company_name.max' =>
                'اسم الشركة يجب ألا تتجاوز 255 محرفاً.',
        ];
    }
}
