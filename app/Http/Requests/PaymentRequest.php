<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
        if(request()->has('is_momo_pay'))
        {
            return [

                'currency' => 'required|string',
                'country' => 'required|string',
                'firstname' => 'nullable',
                'lastname' => 'nullable',
                'phonenumber' => 'required|string',
                'voucher' => 'required|string',
                'network' => 'required|string',
                'cart_id' => 'required|integer',
            ];
        
        }else{

            return [
                'cardno' => 'required|string',
                'currency' => 'required|string',
                'cvv' => 'required|string',
                'phonenumber' => 'nullable|string',
                'expirymonth' => 'required|string',
                'expiryyear' => 'required|string',
                'country' => 'required|string',
                'firstname' => 'nullable',
                'lastname' => 'nullable',
                'cart_id' => 'required|integer',
            ];

        }
    }
}
