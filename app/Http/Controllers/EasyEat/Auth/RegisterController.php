<?php

namespace App\Http\Controllers\EasyEat\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;

class RegisterController extends Controller
{
    //
    public function registerClient(Request $request){

        $validator = Validator::make($request->all(),array(
            'phoneNumber' => 'required|numeric|uniqueUserType:users,phoneNumber,0',
            'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'c_password' => 'required|same:password'
        ));
        if($validator->fails()){
            $response = array(
                "success" => false,
                "data"=> "Validation Error",
                "message" => $validator->errors()
            );

            return response()->json($response,400);
        }

        $input = $request->all();
        $input['name']="";
        $input['email']="";
        $input['loginType']= "0"; //Is 0 for Client
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('EasyEat')->accessToken;
        $success['phoneNumber'] = $user->phoneNumber;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User register successfully.'
        ];
        return response()->json($response,200);
    }

    public function registerServiceProvider(Request $request){

        $validator = Validator::make($request->all(),array(
            'phoneNumber' => 'required|numeric|uniqueUserType:users,phoneNumber,1',
            'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'c_password' => 'required|same:password'
        ));

        if($validator->fails()){
            $response = array(
                "success" => false,
                "data"=> "Validation Error",
                "message" => $validator->errors()
            );

            return response()->json($response,400);
        }

        $input = $request->all();
        $input['name']="";
        $input['email']="";
        $input['loginType']= "1"; //Is 1 for ServiceProviderProfile
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('EasyEat')->accessToken;
        $success['phoneNumber'] = $user->phoneNumber;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User register successfully.'
        ];
        return response()->json($response,200);
    }
}
