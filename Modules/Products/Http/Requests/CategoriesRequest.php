<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'name'      => 'required|max:255|unique:categories,name,'.$this->id,
            'status'    => 'required',
        ];

        return $rules;
    }
    public function messages(): array
    {
        return [
            'name.required'     => 'Yêu cầu nhập dữ liệu',
            'name.unique'       => 'Danh mục đã tồn tại. Yêu cầu nhập lại dữ liệu',
            'status.required'   => 'Yêu cầu nhập dữ liệu',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}