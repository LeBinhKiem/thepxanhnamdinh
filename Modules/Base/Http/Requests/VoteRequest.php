<?php

namespace Modules\Base\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class VoteRequest extends FormRequest
{
    public function rules(Request $request)
    {
        $rules = [
            'star' => 'required|between:1,5',
            'model_id' => 'required',
            'model' => 'required',
        ];

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}

