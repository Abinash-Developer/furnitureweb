<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users',
            'contact_number' => 'required|string|min:10',
            'password'       => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }
        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                "contact_number"=>$request->contact_number,
                'password' => Hash::make($request->password),
            ]);
    
    
            return response()->json([
                "success"=>true,
                "messgae"=>"Customer created successfully",
                'user'         => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success"=>true,
                "messgae"=>$th->getMessage(),
            ]);
        }
    }

    // Login API
    public function login(Request $request)
    {

        try {
            $validator = Validator::make($request->all(),[
               'email'    => 'required|string|email',
                'password' => 'required|string', 
            ]);
            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => $validator->errors()
                ], 422);
            }
            $user = User::where('email', $request->email)->first();
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'success'=>true,
                'message'=>"You have been logging in successfully",
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'user'         => $user,
            ]);
        } catch (\Throwable $th) {
             return response()->json(['success'=>false,"message"=>$th->getMessage()]);
        }
    }

    // Logout API
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
