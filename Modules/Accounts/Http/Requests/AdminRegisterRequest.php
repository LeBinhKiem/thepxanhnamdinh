<?php

namespace Modules\Accounts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRegisterRequest extends FormRequest
{
    public function rules(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone_number' => 'required|min:10|max:10',
            'status' => 'required',
        ];

        $rules["email"] = [
            Rule::unique('admins')->ignore($request->id, 'id'),
            "required",
            "email"
        ];


        return $rules;
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn phải nhập họ tên',
            'status.required' => 'Bạn phải nhập trạng thái',
            'email.required' => 'Bạn phải nhập email',
            'email.unique' => 'Tài khoản email đã được sử dụng',
            'email.email' => 'Bạn phải nhập đúng định dạng @gmail, @email, ...',
            'phone_number.required' => 'Bạn phải nhập số điện thoại',
            'phone_number.min' => 'Số điện thoại bao gồm chỉ 10 số',
            'phone_number.max' => 'Số điện thoại bao gồm chỉ 10 số',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}