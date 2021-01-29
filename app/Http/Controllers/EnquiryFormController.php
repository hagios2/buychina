<?php

namespace App\Http\Controllers;

use App\Mail\EnquiryFormMailHandler;
use App\Http\Requests\EnquiryFormRequest;
use Illuminate\Support\Facades\Mail;

class EnquiryFormController extends Controller
{

    public function handler(EnquiryFormRequest $request)
    {

        $formInputs = $request->validated();


        //EnquiryFormMailHandlerJob::dispatch($formInputs);

        Mail::to('hagioswilson@gmail.com')->queue(new EnquiryFormMailHandler($formInputs));


        return response()->json(['status' => 'mail sent']);

    }
}
