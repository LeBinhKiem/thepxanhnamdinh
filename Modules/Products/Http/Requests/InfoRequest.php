<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class InfoRequest extends FormRequest
{
    public function rules(Request $request)
    {
        $rules = [
            'name'         => 'required|max:255',
            'address'      => 'required',
            'history'      => 'required',
            'achievements' => 'required',
            'introduce'    => 'required',
            'contact'      => 'required',
        ];

        if (empty($request->id)) {
            $rules["logo"] = "required";
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Yêu cầu nhập dữ liệu',
            'address.required'      => 'Yêu cầu nhập dữ liệu',
            'history.required'      => 'Yêu cầu nhập dữ liệu',
            'achievements.required' => 'Yêu cầu nhập dữ liệu',
            'introduce.required'    => 'Yêu cầu nhập dữ liệu',
            'contact.required'      => 'Yêu cầu nhập dữ liệu',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
//        $this->merge([
//            'slug' => Str::slug($this->title),
//        ]);
    }
}