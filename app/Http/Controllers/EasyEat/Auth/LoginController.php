<?php

namespace App\Http\Controllers\EasyEat\Auth;

use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //
    public function loginClient(Request $request){
        $validators = Validator::make($request->all(),array(
            "phoneNumber" => "required|numeric",
            "password" => "required"
        ));

        if($validators->fails()){
            $response = array(
                "success" => false,
                "data"=> "Validation Error",
                "message" => $validators->errors()
            );

            return response()->json($response,400);
        }

        $input = $request->all();
        if(Auth::attempt(array(
            "phoneNumber"=> $input['phoneNumber'],
            "password" => $input['password'],
            "loginType"=> '0' //For Client Login
        ))){
            $theUser = Auth::user();
            $token = $theUser->createToken("EasyEat")->accessToken;
            $response = array(
                'success' => true,
                'data' => array(
                    "user_id"=>$theUser->id,
                    "phoneNumber"=>$theUser->phoneNumber,
                    "token"=> $token
                ),
                'message' => 'User logged in successfully.'
            );
            return response()->json($response,200);

        }else{
            $response = array(
                'success' => false,
                'data' => "",
                'message' => 'User authentification failed.'
            );
            return response()->json($response,200);
        }
    }

    public function loginServiceProvider(Request $request){
        $validators = Validator::make($request->all(),array(
            "phoneNumber" => "required|numeric",
            "password" => "required"
        ));

        if($validators->fails()){
            $response = array(
                "success" => false,
                "data"=> "Validation Error",
                "message" => $validators->errors()
            );

            return response()->json($response,400);
        }

        $input = $request->all();
        if(Auth::attempt(array(
            "phoneNumber"=> $input['phoneNumber'],
            "password" => $input['password'],
            "loginType"=> '1' //For Client Login
        ))){
            $theUser = Auth::user();
            $token = $theUser->createToken("EasyEat")->accessToken;
            $response = array(
                'success' => true,
                'data' => array(
                    "user_id"=>$theUser->id,
                    "phoneNumber"=>$theUser->phoneNumber,
                    "token"=> $token
                ),
                'message' => 'User logged in successfully.'
            );
            return response()->json($response,200);

        }else{

            $response = array(
                'success' => false,
                'data' => "",
                'message' => 'User authentification failed.'
            );
            return response()->json($response,200);
        }
    }
}
