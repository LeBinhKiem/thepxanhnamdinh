<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PlayerRequest extends FormRequest
{
    public function rules(Request $request)
    {
        $rules = [
            'name'         => 'required|max:255',
            'shirt_number' => 'required|numeric|gt:0|unique:players,shirt_number,'.$this->id,
            'birth_day'    => 'required|date',
            'height'       => 'required|gt:0',
            'weight'       => 'required|gt:0',
            'address'      => 'required',
            'position'     => 'required',
            'team'         => 'required',
        ];

        if (empty($request->id)) {
            $rules["avatar"] = "required";
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Yêu cầu nhập dữ liệu',
            'avatar.required'         => 'Yêu cầu nhập dữ liệu',
            'shirt_number.required' => 'Yêu cầu nhập dữ liệu',
            'birth_day.required'    => 'Yêu cầu nhập dữ liệu',
            'height.required'       => 'Yêu cầu nhập dữ liệu',
            'weight.required'       => 'Yêu cầu nhập dữ liệu',
            'description.required'  => 'Yêu cầu nhập dữ liệu',
            'address.required'      => 'Yêu cầu nhập dữ liệu',
            'position.required'     => 'Yêu cầu nhập dữ liệu',
            'team.required'         => 'Yêu cầu nhập dữ liệu',
            'height.gt'    => 'Dữ liệu phải lớn hơn 0',
            'weight.gt'    => 'Dữ liệu phải lớn hơn 0',
            'shirt_number.gt' => 'Dữ liệu phải lớn hơn 0',
            'shirt_number.numeric' => 'Yêu cầu nhập số',
            'shirt_number.unique' => 'Số áo đã được cầu thủ khác dùng. Yêu cầu nhập lại dữ liệu',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {

    }
}