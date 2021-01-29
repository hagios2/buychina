<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportsRequest extends FormRequest
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
            
        if(request()->has('shop_report'))
        {
            return [

                'merchandiser_id' => 'required|integer',

                'report' => 'required|string'
            ];

        }else{

            return [

                'product_id' => 'required|integer',

                'report' => 'required|string'
            ];

        }

    }
}
