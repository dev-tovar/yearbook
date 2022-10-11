<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWallRequest extends FormRequest
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
            'message'     => 'required',
            'user_id'     => 'required|exists:users,id',
            'yearbook_id' => 'required|exists:year_books,id',
            'yearbook_notification_id' => 'exists:yearbook_notifications,id'
        ];
    }
}
