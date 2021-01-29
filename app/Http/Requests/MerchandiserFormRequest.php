<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchandiserFormRequest extends FormRequest
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
            
            'company_name' => 'required|string',

            'email' => 'required|email|unique:merchandisers,email',

            'company_description' => 'required|string',

            'campus_id' => 'required|integer',

            'shop_type_id' => 'required|integer',

            'password' => 'required|string',

            'phone' => 'required|numeric|min:10|unique:merchandisers,phone',
        ];
    }
}
