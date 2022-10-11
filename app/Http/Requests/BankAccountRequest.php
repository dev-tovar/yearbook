<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
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
            'school_id'           => 'required',
//            'bank_name'           => 'alpha|nullable',
            'account_number'      => 'numeric|nullable',
//            'zelle_account'       => '',
//            'paypal_username'     => '',
//            'cashapp_username'    => '',
//            'venmo_username'      => '',
        ];
    }
}
