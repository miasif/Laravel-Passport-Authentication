<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ForgetRequest;
use App\Mail\ForgetMail;
use Illuminate\Support\Facades\Mail;

class ForgetController extends Controller
{
    public function forgetPassword(ForgetRequest $request){
        $email = $request->email;
        if(User::where('email',$email)->doesntExist()){
            return response([
                'message'=>"Email does not exist"
            ],400);
        }
        $token = rand(10,100000);
        try{
            DB::table('password_resets')->insert([
                'email'=>$email,
                'token'=>$token,
                'created_at'=>date('Y-m-d H:i:s')
            ]);
           Mail::to($email)->send(new ForgetMail($token));
            return response([
                'message'=>"Token sent to your email",
            ],200);


        }catch(\Exception $exception){
            return response([
                'message'=>$exception->getMessage()
            ],400);
        }
          
        
    }
}
