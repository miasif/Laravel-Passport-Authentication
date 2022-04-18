<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetRequest;

class ResetController extends Controller
{
    public function resetPassword(ResetRequest $request){
      $email = $request->email;
      $token = $request->token;
      $password = Hash::make($request->password);
      $emailcheck = DB::table('password_resets')->where('email', $email)->first();
      $pincheck = DB::table('password_resets')->where('token', $token)->first();

      if($emailcheck == null){
        return response()->json(['error' => 'Email not found'], 404);
      }
      if($pincheck == null){
        return response()->json(['error' => 'Token not found'], 404);
      }
      DB::table('users')->where('email', $email)->update(['password' => $password]);
      DB::table('password_resets')->where('email', $email)->delete();
        return response()->json(['success' => 'Password reset successfully'], 200);


    }
}
