<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    public function register(RegisterRequest $request){
        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken('app')->accessToken;
            return response()->json([
                'message' => 'User created successfully',
                'token' => $token,
                'user' => $user
            ], 200);
        }catch(\Exception $exception){
            return response([
                'message'=>$exception->getMessage()
            ],400);
        }

    }

    public function login(Request $request){
        try{
            if(Auth::attempt($request->only('email','password'))){
                $user = Auth::user();
                // $accessToken = $user->createToken('app')->accessToken;
                $token = Auth::user()->createToken('app')->accessToken;
                    return response([
                        'message'=>"Login Successful",
                        'token'=>$token,
                        'user'=>$user
                    ],200);    
            }
        }catch(\Exception $exception){
            return response([
                'message'=>$exception->getMessage()
            ],400);
        }
        return response([
            'message'=>"Login Failed"
        ],401);

    }
}
