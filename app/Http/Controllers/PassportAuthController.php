<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;

class PassportAuthController extends Controller
{
    //register
  public function register (Request $request) {
        
    //email exist
    $usermail = User::where('email', $request->email)->first();
    if($usermail){
        return response('The provider email already exists',422);
    }
   
   
    //store the user
    $userToInsert[]=[
        'name' =>$request->name,
        'email' =>$request->email,
        'password' =>Hash::make($request->password),
    ];
    //insert the user
    User::insert($userToInsert);
    //find the user with the provider email
    $user = User::where('email', $request->email)->first();
     //return response
    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
    $response = ['id'=>$user->id,'token' => $token];
    return response($response, 200);
}

//login
public function login (Request $request) {
  
    
    //if the user is registred
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            //find the user
            $user = User::where('email', $request->email)->first();
            //get token
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['id'=>$user->id,'token' => $token];
            return response($response, 200);

    } else {
        //user not exist
        return $this->errorResponse('User does not exist',422);
       
    }
}

public function logout (Request $request) {
    $token = $request->user()->token();
    $token->revoke();
    $response = ['message' => 'You have been successfully logged out!'];
    return response($response, 200);
}
}
