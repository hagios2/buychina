<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSellerRequest;
use App\Http\Resources\MerchandiserPaymentTransactionResource;
use App\Http\Resources\UserSellerPaymentTransactionResource;
use App\MerchandiserPayment;
use App\PaidProduct;
use App\Product;
use App\SellersPayment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserSellerPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('callback');
    }

    public function payment(UserSellerRequest $request)
    {
        $user = auth()->guard('api')->user();

        $paid_product = PaidProduct::where('product_id', $request->product_id)->first();

        if ($request->payment_method === 'card_payment') {
            if (!$user->sellersBillingDetail) {
                $billing_details = $user->addSellersBillingDetail([
                    'cardno' => $request->cardno,
                    'expirymonth' => $request->expirymonth,
                    'expiryyear' => $request->expiryyear,
                    'cvv' => $request->cvv,
                    'billingzip' => $request->billingzip,
                    'billingcity' => $request->billingcity,
                    'billingaddress' => $request->billingaddress,
                    'billingstate' => $request->billingstate,
                ]);
            } else {
                    $user->sellersBillingDetail->update([
                    'cardno' => $request->cardno,
                    'expirymonth' => $request->expirymonth,
                    'expiryyear' => $request->expiryyear,
                    'cvv' => $request->cvv,
                    'billingzip' => $request->billingzip,
                    'billingcity' => $request->billingcity,
                    'billingaddress' => $request->billingaddress,
                    'billingstate' => $request->billingstate,
                ]);

                $billing_details = $user->sellersBillingDetail;
            }

            $payment_details = array_merge($billing_details->toArray(), [
                'amount' => $paid_product->amount,
                'email' => $request->email ?? $user->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
                'callback' => env('USER_PAYMENT_REDIRECT_URL'),
                'product_id' => $request->product_id
            ]);

            $payment_response = (new PaymentService)->payviacard($payment_details);

            if (gettype($payment_response) == 'string') {

                Log::error($payment_response);

                return response()->json(['message' => 'payment process failed']);

            } else {
                Log::info($payment_response);

                SellersPayment::create([
                    'user_id' => $user->id,
                    'billing_detail_id' => $billing_details->id,
                    'amount' => $paid_product->amount,
                    'email' => $payment_details['email'] ,
                    'firstname' => $payment_details['firstname'],
                    'lastname' => $payment_details['lastname'],
                    'phonenumber' => $payment_details['phonenumber'],
                    'txRef' => $payment_response['txref'],
                    'device_ip' => $_SERVER['REMOTE_ADDR'],
                    'product_id' => $payment_details['product_id'],
                ]);

                $payment_response['callback_url'] = route('user.seller.callback');

                return response()->json($payment_response);
            }

        } else { #momo

            $payment_details = [
                'amount' => $paid_product->amount,
                'email' => $request->email ?? $user->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phonenumber' => $request->phonenumber,
                'vendor' => $request->vendor,
                'product_id' => $request->product_id,
                'callback' => env('USER_PAYMENT_REDIRECT_URL'),
            ];

            if($request->vendor === 'VODAFONE')
            {
                $payment_details['voucher'] = $request->voucher;
            }

            $payment_response = (new PaymentService)->payviamobilemoneygh($payment_details);

            if (gettype($payment_response) == 'string') {

                Log::error($payment_response);

                return response()->json(['message' => 'payment process failed']);

            } else {

                Log::info($payment_response);

                SellersPayment::create([
                    'user_id' => $user->id,
                    'amount' => $paid_product->amount,
                    'email' => $payment_details['email'],
                    'firstname' => $payment_details['firstname'],
                    'lastname' => $payment_details['lastname'],
                    'phonenumber' => '233' . substr($payment_details['phonenumber'], -9),
                    'txRef' => $payment_response['txRef'],
                    'device_ip' => $_SERVER['REMOTE_ADDR'],
                    'product_id' => $payment_details['product_id'],
                    'momo_payment' => true,
                    'vendor' => $payment_details['vendor']
                ]);

                $payment_response['callback_url'] = route('user.seller.callback');

                return response()->json($payment_response);
            }

        }
    }


    public function callback(Request $request)
    {
        Log::info($request->all());

        $response= json_decode($request->response, true);

        $txref = $response['txRef'] ?? $response['data']['txRef'];

        Log::info('logging txRef | '. $txref);

        $verified_payment = PaymentService::verifyPayment($txref);

        Log::info('logging Verified Payemnt | '. $verified_payment);

        $payment = SellersPayment::where('txRef',  $txref)->first();

        Log::info('logging User Payment data | '. $payment);

        if('successful' == $verified_payment){

            $payment->update(['status' => 'success']);

            $product = Product::find($payment->product_id);

            $product->update(['payment_status' => 'paid']);

        }else{
            $payment->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'callback received']);
    }

    public function paymentTransactions()
    {
        $transactions = SellersPayment::where('user_id', auth()->guard('api')->id())->get();

        return UserSellerPaymentTransactionResource::collection($transactions);
    }

}
