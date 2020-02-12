<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\ResponseController as ResponseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerController extends ResponseController
{
    public function index(Request $request){
        return $this->sendResponse($request->user(), 'seller signed in successfully');
    }
}
