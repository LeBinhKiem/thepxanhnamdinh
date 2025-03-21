<?php

namespace Modules\Accounts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'phone_number' => 'required|min:10|max:10',
            'sex' => 'required',
        ];


        return $rules;
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn phải nhập họ tên',
            'phone_number.required' => 'Bạn phải nhập số điện thoại',
            'phone_number.min' => 'Số điện thoại bao gồm chỉ 10 số',
            'phone_number.max' => 'Số điện thoại bao gồm chỉ 10 số',
            'sex.required' => 'Bạn phải nhập giới tính',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}