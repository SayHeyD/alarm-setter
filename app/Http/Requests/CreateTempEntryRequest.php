<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateTempEntryRequest extends FormRequest
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
            'recorded' => ['required', 'numeric', 'between:-40,105'],
            'recorded_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'device' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'recorded.required' => 'Recorded Temperature must be set!',
            'recorded.numeric' => 'Recorded Temperature must be numeric!',
            'recorded.between' => 'Recorded Temperature must be between -40 and 105 degrees celsius!',
            'recorded_at.required' => 'Recorded time is required!',
            'recorded_at.date_format' => 'Recorded time must be in the format "Y-m-d H:i:s"!',
            'device.required' => 'Device ID is required!',
        ];
    }
}
