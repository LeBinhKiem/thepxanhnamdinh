<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BLogCategoriesRequest extends FormRequest
{
    public function rules(Request $request)
    {
        $rules = [
            'name'          => 'required|max:255',
            'status'        => 'required',
            'parent_id'     => 'required',
            'slug'          => [Rule::unique('blog_categories')->ignore($request->id, 'id')],
        ];

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->name),
        ]);
    }
    public function messages(): array
    {
        return [
            'name.required'     => 'Yêu cầu nhập dữ liệu',
            'status.required'   => 'Yêu cầu nhập dữ liệu',
            'parent_id.required'    => 'Yêu cầu nhập dữ liệu',
            'slug.unique'       => 'Danh mục đã tồn tại! Xin vui lòng nhập tên khác',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}