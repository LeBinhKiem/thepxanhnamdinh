<?php

namespace Modules\Sell\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PaymentRequest extends FormRequest
{
    public function rules(Request $request)
    {
        $rules = [
            'name'         => 'required|max:255',
            'number_phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
            'address'      => 'required',
            'payment'      => 'required',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'Yêu cầu nhập dữ liệu',
            'name.max'               => 'Tối đa 255 kí tự',
            'number_phone.required'  => 'Yêu cầu nhập dữ liệu',
            'number_phone.regex'     => 'Sai định dạng số điện thoại Việt Nam. VD: 0835787300',
            'number_phone.not_regex' => 'Sai định dạng số điện thoại Việt Nam. VD: 0835787300',
            'number_phone.min'       => 'Sai định dạng số điện thoại Việt Nam. VD: 0835787300',
            'number_phone.max'       => 'Sai định dạng số điện thoại Việt Nam. VD: 0835787300',
            'address.required'       => 'Yêu cầu nhập dữ liệu',
            'payment'                => 'Yêu cầu nhập dữ liệu',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}