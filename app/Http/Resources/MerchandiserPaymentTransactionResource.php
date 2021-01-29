<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MerchandiserPaymentTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phonenumber' => $this->phonenumber,
            'vendor' => $this->vendor,
            'momo_payment' => $this->momo_payment,
            'txRef' => $this->txRef,
            'device_ip' => $this->device_ip,
            'amount' => $this->amount,
            'status' => $this->status,
        ];
    }
}
