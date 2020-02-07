<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    // A base function to generate json response for success


     /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $code=200){
        $response=[
            'success'=>true,
            'data'=>$result,
            'message'=>$message,
        ];

        return response()->json($response,$code);

    }

     /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendError($error, $errorMessage=[], $code=404){

        $response=[
            'success'=>false,
            'message'=>$error,
        ];

        if(!empty($errorMessage)){
            $response['data']=$errorMessage;
        }

        return response()->json($response, $code);
    }


}
