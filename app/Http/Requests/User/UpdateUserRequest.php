<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')
                    ->ignore($user->id),
            ],

            'email' => [
                'sometimes',
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب.',

            'username.required' => 'اسم المستخدم مطلوب.',
            'username.unique' => 'اسم المستخدم مستخدم مسبقاً.',

            'email.email' => 'البريد الإلكتروني غير صحيح.',
            'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً.',

            'password.min' => 'كلمة المرور يجب أن تكون 8 محارف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
        ];
    }
}