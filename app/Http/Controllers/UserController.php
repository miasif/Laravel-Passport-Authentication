<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function getUser(Request $request){
        $user = Auth::user();
        return response()->json($user, 200);
    }
}
