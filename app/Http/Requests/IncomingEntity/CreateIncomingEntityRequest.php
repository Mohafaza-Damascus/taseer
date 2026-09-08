<?php

namespace App\Http\Requests\IncomingEntity;

use App\Http\Requests\BaseRequest;

class CreateIncomingEntityRequest extends BaseRequest
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
                'unique:incoming_entities,name',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>
                'اسم الجهة الواردة مطلوب.',

            'name.string' =>
                'اسم الجهة الواردة يجب أن يكون نصاً.',

            'name.max' =>
                'اسم الجهة الواردة يجب ألا يتجاوز 255 محرفاً.',

            'name.unique' =>
                'اسم الجهة الواردة مستخدم مسبقاً.',

            'notes.string' =>
                'الملاحظات يجب أن تكون نصاً.',
        ];
    }
}