<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MediaRequest extends FormRequest
{
    public function rules(Request $request)
    {
        $rules = [
            'title'      => 'required|max:255',
            'youtube'   => 'required',
            'image'   => 'required',
        ];

        if (empty($request->id)) {
            $rules["image"] = "required";
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required'      => 'Yêu cầu nhập dữ liệu',
            'youtube.required'   => 'Yêu cầu nhập dữ liệu',
            'image.required'    => 'Yêu cầu nhập dữ liệu',
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