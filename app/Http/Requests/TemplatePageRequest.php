<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemplatePageRequest extends FormRequest
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
            'id' => 'required|numeric',
            'yearbook_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'sub_category_id' => 'nullable'
        ];
    }
}
