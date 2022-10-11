<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentManagerCreateRequest extends FormRequest
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
            'category' => 'required',
            'category_id' => 'required',
            'sub_category' => 'nullable',
            'sub_category_id' => 'nullable',
            'school_id' => 'required',
            'yearbook_id' => 'required',
            'name' => 'required',
            'create' => 'required',
            'editable' => 'required'
        ];
    }
}
