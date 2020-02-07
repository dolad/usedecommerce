<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\ResponseController as ResponseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends ResponseController
{
    /**
     * Register an client
     *
     * @return \Illuminate\Http\Response
     */

     public function register(Request $request){

        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
         ]);

         if($validator->fails()){
             return $this->sendResponse("Validation Error", $validator->errors());
         }
         $user=User::create([
             'name'=>$request->name,
             'email'=>$request->email,
             'password'=>Hash::make($request->password),
         ]);

         $success['token']=$user->createToken('MyApp')->accessToken;
         $succees['name'] = $user->name;
         return $this->sendResponse($success, 'Seller registration succeessfull');

     }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password]))
           {
            $user=Auth::user();
            $success['token']=$user->createToken('MyApp')->accessToken;
             return $this->sendResponse($success,'Login succeessfully');
           }
        else
           {

            $ErrorMessage='unauthorized seller';
            return $this->sendError("Unauthorized", $ErrorMessage);

            }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
