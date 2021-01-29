<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchandiserPaymentRequest extends FormRequest
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
        if(request()->payment_method == 'card_payment')
        {
            return [
                'cardno' => 'required|numeric|min:16',
                'expirymonth' => 'required|numeric',
                'expiryyear' => 'required|numeric',
                'cvv' => 'required|numeric',
                'billingzip' => 'required|string',
                'billingcity' => 'required|string',
                'billingaddress' => 'required|string',
                'billingstate' => 'required|string',
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'phonenumber' => 'required|string',
                'payment_method' => 'required|string',
                'email' => 'required|string',
            ];

        }elseif (request()->payment_method == 'momo'){

            return [
                'voucher' => 'nullable|numeric',
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'phonenumber' => 'required|string',
                'payment_method' => 'required|string',
                'email' => 'required|string',
                'vendor' => 'required|string'
            ];

        }else{
            return ['payment_method' => 'required|string'];
        }
    }
}
