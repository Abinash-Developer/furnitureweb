<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthControllerWeb extends Controller
{
    public function login(UserLoginRequest $request){
       try {
         $user = User::where('email',$request->email)->first();
         if(!$user || !Hash::check($request->password,$user->password)){
            throw new Exception("Invalid Credential");
         }
         Auth::login($user);
         $request->session()->regenerate();
         return response()->json([
               "success"=>true,
               "message"=>"Logged in successfully",
         ]);
       } catch (\Throwable $th) {
        return response()->json([
               "success"=>false,
               "message"=>$th->getMessage(),
         ]);
       }
    }
}
