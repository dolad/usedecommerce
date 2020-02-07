<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/unauthenticateduser', function(){
        $response=[
            'success'=>true,
            'message'=>'Unauthorized users',];
        $code=402;
        return response()->json($response,$code);
})->name('unauth');


// Register routes
Route::post('/register','Seller\AuthController@register');
Route::post('/login','Seller\AuthController@login');

// Route group for authenticated user
Route::group(['prefix'=>'sellers/v1','middleware'=>'auth:api'],function(){

    // Route::post('/register','Seller\AuthController@register');

});
