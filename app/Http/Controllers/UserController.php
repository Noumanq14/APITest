<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated()))
        {
            $user = Auth::user();
//            session(['user' => $user]);

            $aArrayReturn = array(
                'token' => $user->createToken('user-token')->plainTextToken,
                'user' => $user
            );

            return response()->json([
                'success' => true,
                'message'    => 'User Login Successfully',
                'data'       => $aArrayReturn
            ],200);
        }
        else
            return response()->json([
                'success' => false,
                'message'   => 'Unable to login',
                'data'  => ''
            ],400);
    }

    public function register(RegisterRequest $request)
    {
        $sUserName = $request->get("name");
        $sPassword = $request->get("password");
        $sEmail    = $request->get("email");


        $user = new User();

        $user["name"] = $sUserName;
        $user["email"] = $sEmail;
        $user["password"] = bcrypt($sPassword);

        $user->save();
        $aArrayReturn = array(
            'token' => $user->createToken('user-token')->plainTextToken
        );
        return response()->json([
            'success' => true,
            'message'   => 'User Registered Successfully',
            'data'  => $aArrayReturn
        ],200);
    }
}
