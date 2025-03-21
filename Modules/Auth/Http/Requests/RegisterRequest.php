<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'full_name' => 'required',
            'name' => 'required|unique:users|min:10|not_regex:/\s/|regex:/^[a-zA-Z0-9]+$/u',
            'email' => 'required|email|ends_with:@gmail.com,@email.com|unique:users',
            'password' => 'required|min:8',
        ];


        return $rules;
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Bạn phải nhập họ tên',
            'name.required' => 'Bạn phải nhập tên tài khoản',
            'name.not_regex' => 'Sai định dạng tên tài khoản! Ví dụ: namdinhfc',
            'name.regex' => 'Sai định dạng tên tài khoản! Ví dụ: namdinhfc',
            'name.unique' => 'Tên tài khoản đã tồn tại',
            'name.min' => 'Tên tài khoản phải lớn hơn 10 kí tự',
            'email.required' => 'Bạn phải nhập Email',
            'email.email' => 'Yêu cầu nhập đúng định dạng @gmail.com, @email.com...',
            'email.ends_with' => 'Yêu cầu nhập đúng định dạng @gmail.com, @email.com...',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Bạn phải nhập mật khẩu',
            'password.min' => 'Mật khẩu yêu cầu trên 8 kí tự',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
