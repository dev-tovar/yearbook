<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyStudentTributeRequest extends FormRequest
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
            'template_id' => 'required|exists:templates,id',
            'category_id' => 'required|exists:content_categories,id',
            'user_id'     => 'required|exists:users,id',
            'yearbook_id' => 'required|exists:year_books,id',
        ];
    }
}
