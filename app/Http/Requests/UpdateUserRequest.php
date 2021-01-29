<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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

            'email' => 'required|email',

            'phone' => 'required|numeric',

            'avatar' => 'nullable|image|mimes:jpeg,jpg,png',

            'campus_id' => 'required|integer' 
            //
        ];
    }
}
