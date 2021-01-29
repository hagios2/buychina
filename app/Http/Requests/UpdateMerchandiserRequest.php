<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMerchandiserRequest extends FormRequest
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

            'email' => 'required|email',

            'company_description' => 'required|string',

            'campus_id' => 'required|integer',

            'phone' => 'required|numeric|min:10|',
        ];
    }
}
