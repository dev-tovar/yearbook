<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonate extends FormRequest
{

//    protected $redirectAction = 'Admin\DonateController@index';

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
            //'amount' => 'required|regexs:/^[\d\,]+(\.[0-9]+)?$/i'
            'amount' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'amount.required' => 'Amount is required',
            'amount.regex'  => 'Amount should have correct format.',
        ];
    }
}
