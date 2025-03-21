<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class LoginUserRequest extends FormRequest
{
    public function rules(Request $request)
    {
        $rules = [
            'name' => 'required',
            'password' => 'required',
        ];


        return $rules;
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn phải nhập tên tài khoản',
            'password.required' => 'Bạn phải nhập mật khẩu',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}