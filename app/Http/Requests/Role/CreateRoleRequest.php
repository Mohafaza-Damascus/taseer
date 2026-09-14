<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:roles,slug',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'integer',
                'exists:permissions,id',
                'distinct',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الدور مطلوب.',

            'slug.required' => 'الـ slug مطلوب.',
            'slug.unique' => 'هذا الـ slug مستخدم مسبقًا.',

            'permissions.array' => 'الصلاحيات غير صحيحة.',
            'permissions.*.exists' => 'إحدى الصلاحيات المحددة غير موجودة.',
            'permissions.*.distinct' => 'لا يمكن تكرار الصلاحية.',
        ];
    }
}