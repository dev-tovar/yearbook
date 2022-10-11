<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrivacyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_privacy'  => 'required|numeric',
            'email_privacy'  => 'required|numeric',
            'gps_privacy'    => 'required|numeric',
            'career_privacy' => 'required|numeric',
        ];
    }
}
