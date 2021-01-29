<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            
            'name' => 'required|string',

            'email' => 'required|email|unique:users,email',

            'phone' => 'required|numeric|unique:users,phone',

            'avatar' => 'nullable|image|mimes:jpeg,jpg,png',

            'password' => 'required|string',

            'campus_id' => 'required|integer'
        ];
    }
}
