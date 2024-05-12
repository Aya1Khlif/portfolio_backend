<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
      //Register Api(post ,formatdata)
    //DATA VALIDATION
    public function register(Request $request)
    {
        $request->validate(
          [
            "name" => "required",
            "email" => "required |email|unique:users",
            "password" => "required|confirmed"
          ]
        );

        //data save
    User::created([
    "name"=> $request ->name,
    "email"=> $request->email,
    "password"=>Hash::make($request->password)
    ]);
    //Response
       return response()->json([
       "status"=> true,
       "message"=> "User created successsfuly",
      ]);
    }
    //login api (post ,formatdata)
    public function login(Request $request){
        //data validation
        $request->validate(
            [
                "email"=>"required|email",
                "password"=>"required"
            ]
            );
                //JWTAuth and attempt
            $token=JWTAuth::attempt([
            "email"=> $request -> email,
            "password"=>$request ->password
            ]);

            if(!empty($token)){
                    //Respons
                    return response([
                        "status"=> true,
                        "message"=>"User logged in successfully",
                        "token"=>$token
                    ]);
      }

      return response()->json([
        "status"=>false,
        "message"=> "Invalid Login details"
      ]);

    }
    //profile api (get)
    public function profile(){
       $userdata=auth()->user();
       return response()->json([
        "status"=>true,
        "message"=>"profile data",
        "user"=>$userdata
       ]);
    }
}
