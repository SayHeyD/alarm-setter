<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SetTempLimitsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'topLimit' => ['required', 'numeric', 'between:-40,105', 'gt:bottomLimit'],
            'bottomLimit' => ['required', 'numeric', 'between:-5,60'],
        ];
    }

    public function messages()
    {
        return [
            'topLimit.required' => 'Oberes Limit muss ausgefüllt sein!',
            'topLimit.gt' => 'Oberes Limit muss höher sein als das Untere Limit',
            'bottomLimit.required' => 'Unteres Limit muss ausgefüllt sein!',
            'topLimit.between' => 'Das Limit muss zwischen -5 und 50 sein!',
            'bottomLimit.between' => 'Das Limit muss zwischen -5 und 50 sein!',
            'topLimit.numeric' => 'Oberes Limit muss ein numerischer Wert sein!',
            'bottomLimit.numeric' => 'Unteres Limit muss ein numerischer Wert sein!',
        ];
    }
}
