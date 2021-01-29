<?php


namespace App\Services;


use App\Transaction;
use Illuminate\Http\Request;

class PaymentService
{

    public function getKey($seckey){

        $hashedkey = md5($seckey);
        $hashedkeylast12 = substr($hashedkey, -12);

        $seckeyadjusted = str_replace("FLWSECK-", "", $seckey);
        $seckeyadjustedfirst12 = substr($seckeyadjusted, 0, 12);

        $encryptionkey = $seckeyadjustedfirst12.$hashedkeylast12;
        return $encryptionkey;

    }


    public function encrypt3Des($data, $key)
    {
        $encData = openssl_encrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA);
        return base64_encode($encData);
    }



    public function payviacard($billing_details)
    { // set up a function to test card payment.

        error_reporting(E_ALL);
        ini_set('display_errors',1);

        $txref =  'Martek Payment-' .now();

        $data = array('PBFPubKey' => env('RAVE_PUBLIC_KEY'),
            'cardno' => $billing_details['cardno'],
            'currency' => 'GHS',
            'country' => 'GH',
            'amount' => $billing_details['amount'],
            "cvv"=> $billing_details['cvv'],
            "expirymonth"=> $billing_details['expirymonth'],
            "expiryyear"=> $billing_details['expiryyear'],
            'email' => $billing_details['email'],
            'firstname' => $billing_details['firstname'],
            'lastname' => $billing_details['lastname'],
            'phonenumber' => $billing_details['phonenumber'],
            'IP' => $_SERVER['REMOTE_ADDR'],
            'txRef' => $txref,
            "redirect_url" => $billing_details['callback']
        );

        $request = $this->initiateCard($data);

        if ($request)
        {
            $result = json_decode($request, true);

            if($result['status'] == 'success')
            {
                if(array_key_exists('suggested_auth', $result['data']))
                {
                    if($result['data']['suggested_auth'] == 'NOAUTH_INTERNATIONAL' || $result['data']['suggested_auth'] == 'AVS_VBVSECURECODE') {

                        $data['suggested_auth'] = "NOAUTH_INTERNATIONAL";
                        $data['billingzip'] = $billing_details['billingzip'];
                        $data["billingcity"] = $billing_details['billingcity'];
                        $data['billingaddress'] = $billing_details['billingaddress'];
                        $data['billingstate'] = $billing_details['billingstate'];
                        $data['billingcountry'] = $billing_details['billingcountry'];

                        $result = json_decode($this->initiateCard($data), true);

                    }else if($result['data']['suggested_autth'] == 'PIN') {

                        return  'payment requires PIN';
                    }
                }

                return [
                    'status' => 'success',
                    'authurl' => $result['data']['authurl'],
                    'chargeResponseMessage' => $result['data']['chargeResponseMessage'],
                    'redirect_url' => $billing_details['callback'],
                    'txref' => $txref
                ];
            }

        }else{

            return 'Payment failed';
        }


    }

    public function encryptKeys($data)
    {
        $SecKey = env('RAVE_SECRET_KEY');

        $key = $this->getKey($SecKey);

        $dataReq = json_encode($data);

        $post_enc = $this->encrypt3Des( $dataReq, $key );

        $postdata = array(
            'PBFPubKey' => env('RAVE_PUBLIC_KEY'),
            'client' => $post_enc,
            'alg' => '3DES-24');

        return $postdata;

    }

    public function initiateCard($data)
    {
        $postdata = $this->encryptKeys($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/charge");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata)); //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 200);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);

        $headers = array('Content-Type: application/json');

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec($ch);

        curl_close($ch);

        return $request;
    }

    public function payviamobilemoneygh($payment_details){

        error_reporting(E_ALL);
        ini_set('display_errors',1);

        $txref =  'Martek Payment-' .now();

        $data = array('PBFPubKey' => env('RAVE_PUBLIC_KEY'),
            'currency' => 'GHS',
            'country' => 'GH',
            'payment_type' => 'mobilemoneygh',
            'amount' => $payment_details['amount'],
            'phonenumber' => $payment_details['phonenumber'],
            'firstname' => $payment_details['firstname'],
            'lastname' => $payment_details['lastname'],
            'network' => $payment_details['vendor'],
            'email' => $payment_details['email'],
            'IP' => $_SERVER['REMOTE_ADDR'],
            'txRef' => $txref,
            'orderRef' => 'Martek Payment-' .now(),
            'is_mobile_money_gh' => 1,
            "redirect_url" =>  $payment_details['callback']
        );

        if($data['network'] === 'VODAFONE')
        {
            $data['voucher'] = $payment_details['voucher'];
        }

        $request = $this->initiateCard($data);

        if($request)
        {
            $result = json_decode($request, true);

            $result['txRef'] = $txref;

            return $result;
        }else{

            return $request;
        }
    }


    public static function verifyPayment($txref)
    {
        $result = array();

        $postdata =  array(
            'txref' => $txref,
            'SECKEY' =>  env('RAVE_SECRET_KEY')
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec ($ch);
        $err = curl_error($ch);

        if($err){
            // there was an error contacting rave
            return 'Curl returned error: ' . $err;
        }


        curl_close ($ch);

        $result = json_decode($request, false);

        if('error' == $result->status){
            // there was an error from the API
            return 'API returned error: ' . $result->message;
        }

        if('successful' == $result->data->status && '00' == $result->data->chargecode){
            // transaction was successful...
            // please check other things like whether you already gave value for this ref
            // If the amount and currency matches the expected amount and currency etc.
            // if the email matches the customer who owns the product etc
            // Give value
            return $result->data->status;
        }
    }


}
