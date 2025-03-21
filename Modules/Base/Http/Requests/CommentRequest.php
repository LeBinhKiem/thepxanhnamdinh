<?php

namespace Modules\Base\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CommentRequest extends FormRequest
{
    public function rules(Request $request)
    {
        $rules = [
            'comment' => 'required',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'comment.required' => 'Yêu cầu nhập dữ liệu',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }
}

