<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReportsRequest;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,admin');
    }


    public function saveShopReport(ReportsRequest $request)
    {
        auth()->guard('api')->user()->addShopReport($request->validated());

        return response()->json(['status' => 'saved']);
    }


    public function saveProductReport(ReportsRequest $request)
    {
        auth()->guard('api')->user()->addProductReport($request->validated());

        return response()->json(['status' => 'saved']);
    }
}
