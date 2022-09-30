<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class ApiRegistrationRequest extends FormRequest
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
        if ($this->get('user_type') == 'student') {
            $userId = '';
            if($user = User::whereHas('users_yearbooks',function ($q){
                $q->where('users_year_books.id',$this->get('uuid'));
            })->first()){
                $userId = ",{$user->id}";
            }
            return [
                'uuid' => 'required|numeric',
                'email' => 'required|email|unique:users,email'.$userId,
                'name' => 'required|min:6',
                'grade_level' => 'required',
                'city' => 'required',
                'state' => 'required',
                'school_id' => 'required|numeric',
                'user_type' => 'required'
            ];
        }
        else {
            return [
                'email' => 'required|email|unique:users',
                'name' => 'required|min:6',
                'childes' => 'required',
                'user_type' => 'required'
            ];
        }
    }
}
