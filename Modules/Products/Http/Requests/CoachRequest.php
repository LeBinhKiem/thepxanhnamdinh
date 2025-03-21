<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CoachRequest extends FormRequest
{
    public function rules(Request $request)
    {
        $rules = [
            'name'      => 'required|max:255',
            'birth_day' => 'required|date',
            'position' => 'required',
            'address'   => 'required',
        ];

        if (empty($request->id)) {
            $rules["avatar"] = "required";
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Yêu cầu nhập dữ liệu',
            'birth_day.required' => 'Yêu cầu nhập dữ liệu',
            'position.required' => 'Yêu cầu nhập dữ liệu',
            'address.required'   => 'Yêu cầu nhập dữ liệu',
            'avatar.required'    => 'Yêu cầu nhập dữ liệu',
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