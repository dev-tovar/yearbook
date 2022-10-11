<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WallActionRequest extends FormRequest
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
            'yearbook_notification_id' => 'exists:yearbook_notifications,id'
        ];
    }
}
