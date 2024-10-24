<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){
        // $user = User::created();

        $userValidator = Validator::make(
            $request->all(),
            [
                'role' => ['required', 'in:student,driver,guardian'],
                'name' => 'required',
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required','min:8'],
                'confirm' => ['required', 'same:password'],
            ]
        );

        if($userValidator->fails()){
            return response()->json([
                'status'=> false,
                'message'=> 'Validation Error',
                'errors'=> $userValidator->errors()->all()
            ],401);
        }
        // echo "<pre>";
        // print_r($request->all());
        $user = User::create([
            'role' => $request->role,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json([
            'status'=> true,
            'message'=> 'User created successfuly',
            'user'=> $user
        ],200);
    }

    public function login(Request $request){
        $userValidator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );
        
        if($userValidator->fails()){
            return response()->json([
                'status'=> false,
                'message'=> 'Validation Error',
                'errors'=> $userValidator->errors()->all()
            ],401);
        }

        // echo "<pre>";
        // print_r($request->all());

        if(Auth::attempt([ 'email'=>$request->email, 'password'=>$request->password])){
            $user = Auth::user();
            // echo "<pre>";
            // print_r($user);
            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'User logged in successfully',
                    'user' => $user,
                    'token' => $user->createToken('Api_Token')->accessToken,
                ], 200);
            }
        }else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }
        echo "<pre>";
        print_r($request->all());
    }

    public function logout(Request $request){
        // Retrieve the authenticated user
        $user = Auth::guard('api')->user();

        // Revoke the user's current access token
        $user->token()->revoke();

        // Optional: You may want to revoke all tokens for the user
        // $user->tokens()->delete();

        return response()->json(['status'=>true,'message' => 'Successfully logged out.'], 200);
        // $request->user()->token()->revoke();
        // return response()->json([
        //     'message' => 'Successfully logged out'
        // ]);
    }

    public function getUser()
    {
        $user = Auth::guard('api')->user();
        $user = User::find($user->id);
        
        if (is_null($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404); // Return 404 Not Found
        }
        
        return response()->json([
            'status' => true,
            'message' => 'User found',
            'user' => $user,
        ], 200); // Return 200 OK
    }
}
